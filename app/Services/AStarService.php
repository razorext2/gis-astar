<?php

namespace App\Services;

use App\DTOs\AStarResult;
use App\DTOs\GeoPoint;
use App\Enums\TipeTitikRute;
use App\Models\RumahSakit;
use Illuminate\Support\Collection;

/**
 * Implementasi algoritma A* untuk pencarian rumah sakit rujukan terbaik.
 *
 * Menggunakan integrasi jaringan jalan OSRM (Open Source Routing Machine):
 *   - Cost g(n)      = Jarak jalan nyata (km) dari pasien ke RS kandidat via OSRM (dengan fallback Haversine)
 *   - Heuristic h(n) = 0 (karena RS kandidat merupakan goal node langsung)
 *   - f(n)           = g(n) + h(n) = total estimasi jarak evaluasi A*
 */
class AStarService
{
    /** Radius bumi dalam kilometer */
    private const EARTH_RADIUS_KM = 6371;

    /** Asumsi kecepatan rata-rata dalam kota (km/jam) */
    private const AVERAGE_SPEED_KMH = 40;

    /** Tarif ambulan per km — dikonfigurasi via AMBULANCE_COST_PER_KM di .env */
    private const DEFAULT_COST_PER_KM = 5000;

    public function __construct(
        private readonly ?OsrmService $osrmService = null,
    ) {}

    /**
     * Temukan RS terbaik dari daftar kandidat menggunakan A* berbasis jarak jaringan jalan OSRM.
     *
     * @param  float  $fromLat  Latitude pasien
     * @param  float  $fromLng  Longitude pasien
     * @param  Collection  $hospitals  Kandidat RS (Collection<RumahSakit>)
     */
    public function findBestHospital(
        float $fromLat,
        float $fromLng,
        Collection $hospitals
    ): AStarResult {
        if ($hospitals->isEmpty()) {
            throw new \InvalidArgumentException('Daftar rumah sakit kandidat tidak boleh kosong.');
        }

        // Ambil matriks jarak jalan dan durasi tempuh via OSRM Table API
        $osrm = $this->osrmService ?? app(OsrmService::class);
        $metrics = $osrm->getDistancesAndDurations($fromLat, $fromLng, $hospitals);

        // Hitung f(n) untuk setiap kandidat RS
        $scored = $hospitals->map(function (RumahSakit $hospital) use ($fromLat, $fromLng, $metrics) {
            $metric = $metrics[$hospital->id_rumah_sakit] ?? null;

            if ($metric !== null) {
                $distance = (float) $metric['distance'];
                $estimatedTime = (int) $metric['duration'];
                $isRoadDistance = (bool) ($metric['is_road_distance'] ?? true);
            } else {
                // Fallback internal jika tidak ditemukan di matriks
                $distance = $this->haversine($fromLat, $fromLng, $hospital->latitude, $hospital->longitude);
                $estimatedTime = $this->estimateTime($distance);
                $isRoadDistance = false;
            }

            $estimatedCost = $this->estimateCost($distance);

            // Evaluasi A*: f(n) = g(n) + h(n)
            // g(n) = jarak jalan nyata ke RS
            // h(n) = 0 (karena RS adalah goal node langsung)
            $fScore = $distance;

            return [
                'hospital' => $hospital,
                'distance' => $distance,
                'estimated_time' => $estimatedTime,
                'estimated_cost' => $estimatedCost,
                'f_score' => $fScore,
                'is_road_distance' => $isRoadDistance,
            ];
        });

        // Sort ascending berdasarkan f(n) → RS terdekat dan optimal di index 0
        $ranked = $scored->sortBy('f_score')->values();

        $best = $ranked->first();

        // Buat waypoints: [titik awal (pasien), titik tujuan (RS terpilih)]
        $waypoints = [
            new GeoPoint(
                lat: $fromLat,
                lng: $fromLng,
                label: 'Lokasi Pasien',
                tipe: TipeTitikRute::Awal,
            ),
            new GeoPoint(
                lat: $best['hospital']->latitude,
                lng: $best['hospital']->longitude,
                label: $best['hospital']->nama_rumah_sakit,
                tipe: TipeTitikRute::Tujuan,
            ),
        ];

        return new AStarResult(
            bestHospital: $best['hospital'],
            allRanked: $ranked->all(),
            totalDistance: round($best['distance'], 3),
            estimatedTime: $best['estimated_time'],
            estimatedCost: $best['estimated_cost'],
            waypoints: $waypoints,
            algorithm: 'astar',
            fScore: round($best['f_score'], 4),
        );
    }

    /**
     * Haversine formula — menghitung jarak garis lurus antara dua koordinat.
     * Hasil dalam kilometer. Admissible sebagai heuristic A* karena selalu <= jarak jalan nyata.
     */
    public function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS_KM * $c;
    }

    /**
     * Estimasi waktu tempuh berdasarkan jarak.
     * Asumsi kecepatan rata-rata 40 km/jam dalam kota.
     *
     * @return int Estimasi waktu dalam menit
     */
    private function estimateTime(float $distanceKm): int
    {
        return (int) ceil(($distanceKm / self::AVERAGE_SPEED_KMH) * 60);
    }

    /**
     * Estimasi biaya rujukan berdasarkan jarak.
     * Tarif per km dibaca dari config (AMBULANCE_COST_PER_KM di .env), default Rp5.000/km.
     *
     * @return float Estimasi biaya dalam Rupiah
     */
    private function estimateCost(float $distanceKm): float
    {
        $costPerKm = (int) config('services.ambulance.cost_per_km', self::DEFAULT_COST_PER_KM);

        return $distanceKm * $costPerKm;
    }
}
