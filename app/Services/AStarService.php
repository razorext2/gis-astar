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
 * Dalam mode development (OSM):
 *   - Heuristic h(n) = Haversine distance ke RS target
 *   - Cost g(n)      = Haversine distance dari pasien ke node
 *   - f(n)           = g(n) + h(n) = total estimasi jarak
 *
 * Karena semua kandidat RS adalah goal node langsung (tidak ada graph perantara),
 * algoritma disederhanakan: hitung f(n) untuk setiap RS, pilih yang terkecil.
 */
class AStarService
{
    /** Radius bumi dalam kilometer */
    private const EARTH_RADIUS_KM = 6371;

    /** Asumsi kecepatan rata-rata dalam kota (km/jam) */
    private const AVERAGE_SPEED_KMH = 40;

    /** Tarif ambulan per km (Rupiah) */
    private const COST_PER_KM = 5000;

    /**
     * Temukan RS terbaik dari daftar kandidat menggunakan A*.
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
        // Hitung f(n) untuk setiap kandidat RS
        $scored = $hospitals->map(function (RumahSakit $hospital) use ($fromLat, $fromLng) {
            $distance = $this->haversine($fromLat, $fromLng, $hospital->latitude, $hospital->longitude);
            $estimatedTime = $this->estimateTime($distance);
            $estimatedCost = $this->estimateCost($distance);

            // f(n) = g(n) + h(n)
            // g(n) = haversine(pasien → RS)
            // h(n) = 0 (RS adalah goal node langsung)
            $fScore = $distance;

            return [
                'hospital' => $hospital,
                'distance' => $distance,
                'estimated_time' => $estimatedTime,
                'estimated_cost' => $estimatedCost,
                'f_score' => $fScore,
            ];
        });

        // Sort ascending berdasarkan f(n) → RS terdekat di index 0
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
     * Hasil dalam kilometer. Admissible sebagai heuristic A* karena selalu ≤ jarak jalan nyata.
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
     * Asumsi tarif ambulan Rp 5.000/km.
     *
     * @return float Estimasi biaya dalam Rupiah
     */
    private function estimateCost(float $distanceKm): float
    {
        return $distanceKm * self::COST_PER_KM;
    }
}
