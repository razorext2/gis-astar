<?php

namespace App\Services;

use App\DTOs\AStarResult;
use App\DTOs\ReferralProcessResult;
use App\Enums\MetodeRujukan;
use App\Enums\StatusRujukan;
use App\Exceptions\BusinessException;
use App\Models\DetailRujukan;
use App\Models\Pasien;
use App\Models\Rujukan;
use App\Models\Rute;
use App\Models\TitikRute;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Orkestrator utama untuk proses perujukan otomatis.
 *
 * Alur kerja:
 *  1. Validasi koordinat pasien
 *  2. Scoring: getCandidates (filter layanan + radius)
 *  3. A*: findBestHospital (ranking Haversine)
 *  4. Persist: simpan semua hasil ke DB dalam satu transaksi
 *
 * Berjalan SYNCHRONOUS dalam Livewire request cycle.
 */
class ReferralService
{
    public function __construct(
        private readonly AStarService $astar,
        private readonly HospitalScoringService $scoring,
    ) {}

    /**
     * Entry point utama — dipanggil dari Livewire Handler.
     *
     * @throws BusinessException Jika koordinat pasien kosong atau tidak ada kandidat RS
     */
    public function processReferral(
        Pasien $pasien,
        string $layananDibutuhkan,
        User $requestedBy,
        int $radiusKm = 50
    ): ReferralProcessResult {
        // 1. Validasi koordinat pasien
        if (! $pasien->hasCoordinates()) {
            throw new BusinessException(
                "Data koordinat pasien '{$pasien->nama}' belum diisi. ".
                'Harap lengkapi latitude dan longitude pasien terlebih dahulu.'
            );
        }

        // 2. Cari kandidat RS
        $candidates = $this->scoring->getCandidates(
            lat: $pasien->latitude,
            lng: $pasien->longitude,
            layanan: $layananDibutuhkan,
            radiusKm: $radiusKm,
        );

        if ($candidates->isEmpty()) {
            throw new BusinessException(
                "Tidak ditemukan rumah sakit dengan layanan \"{$layananDibutuhkan}\" ".
                "dalam radius {$radiusKm} km dari lokasi pasien. ".
                'Coba perluas radius pencarian atau pilih layanan lain.'
            );
        }

        // 3. Jalankan A* untuk temukan RS terbaik
        $astarResult = $this->astar->findBestHospital(
            fromLat: $pasien->latitude,
            fromLng: $pasien->longitude,
            hospitals: $candidates,
        );

        // 4. Simpan semua hasil ke DB dalam satu transaksi
        $rujukan = DB::transaction(function () use ($pasien, $layananDibutuhkan, $requestedBy, $astarResult) {
            return $this->persistResult($astarResult, $pasien, $requestedBy, $layananDibutuhkan);
        });

        return new ReferralProcessResult(
            astarResult: $astarResult,
            rujukan: $rujukan,
        );
    }

    /**
     * Simpan hasil A* ke DB.
     * Urutan: rute → titik_rute → rujukan → detail_rujukan
     */
    private function persistResult(
        AStarResult $result,
        Pasien $pasien,
        User $user,
        string $layanan
    ): Rujukan {
        // 1. Simpan Rute
        $rute = Rute::create([
            'nama_rute' => "Rute {$pasien->nama} → {$result->bestHospital->nama_rumah_sakit}",
            'jarak_total' => $result->totalDistance,
            'waktu_total' => $result->estimatedTime,
            'algoritma' => $result->algorithm,
        ]);

        // 2. Simpan TitikRute (waypoints)
        foreach ($result->waypoints as $index => $geoPoint) {
            TitikRute::create([
                'id_rute' => $rute->id_rute,
                'urutan' => $index + 1,
                'nama_lokasi' => $geoPoint->label,
                'latitude' => $geoPoint->lat,
                'longitude' => $geoPoint->lng,
                'tipe' => $geoPoint->tipe->value,
            ]);
        }

        // 3. Buat Rujukan
        $rujukan = Rujukan::create([
            'no_rujukan' => Rujukan::generateNoRujukan(),
            'id_pasien' => $pasien->id_pasien,
            'id_rumah_sakit' => $result->bestHospital->id_rumah_sakit,
            'id_user' => $user->id,
            'tanggal_rujukan' => now(),
            'status' => StatusRujukan::Pending->value,
            'keterangan' => "Rujukan otomatis A* untuk layanan: {$layanan}",
        ]);

        // 4. Simpan DetailRujukan
        DetailRujukan::create([
            'id_rujukan' => $rujukan->id_rujukan,
            'id_rute' => $rute->id_rute,
            'jarak' => $result->totalDistance,
            'waktu_tempuh' => $result->estimatedTime,
            'estimasi_biaya' => $result->estimatedCost,
            'metode' => MetodeRujukan::Otomatis->value,
        ]);

        return $rujukan->load(['pasien', 'rumahSakit', 'detailRujukan.rute']);
    }
}
