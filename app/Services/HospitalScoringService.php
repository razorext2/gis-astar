<?php

namespace App\Services;

use App\Models\RumahSakit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Service untuk memfilter dan mengurutkan kandidat rumah sakit rujukan.
 * Menggunakan JSON_CONTAINS untuk filter layanan dan Haversine untuk radius.
 */
class HospitalScoringService
{
    /** Radius default pencarian dalam km */
    private const DEFAULT_RADIUS_KM = 50;

    /** Maksimum kandidat yang dikembalikan */
    private const DEFAULT_LIMIT = 10;

    /**
     * Ambil kandidat RS berdasarkan layanan yang dibutuhkan dan radius km.
     *
     * Filter urutan:
     *  1. JSON_CONTAINS(layanan_operasi, '"ICU"') → hanya RS yang punya layanan
     *  2. Haversine PHP → filter dan sort dalam radius
     *  3. Limit → maksimum kandidat
     *
     * @param  float  $lat  Latitude pasien
     * @param  float  $lng  Longitude pasien
     * @param  string  $layanan  Layanan yang dibutuhkan (contoh: "ICU")
     * @param  int  $radiusKm  Radius maksimum (km)
     * @param  int  $limit  Maksimum kandidat
     * @return Collection<RumahSakit>
     */
    public function getCandidates(
        float $lat,
        float $lng,
        string $layanan,
        int $radiusKm = self::DEFAULT_RADIUS_KM,
        int $limit = self::DEFAULT_LIMIT
    ): Collection {
        // Query RS yang memiliki layanan yang dibutuhkan (JSON_CONTAINS)
        $hospitals = $this->queryByLayanan($layanan)->get();

        // Filter radius menggunakan Haversine PHP-level dan sort ascending
        return $hospitals
            ->filter(fn (RumahSakit $rs) => $this->haversineDistance($lat, $lng, $rs->latitude, $rs->longitude) <= $radiusKm)
            ->sortBy(fn (RumahSakit $rs) => $this->haversineDistance($lat, $lng, $rs->latitude, $rs->longitude))
            ->take($limit)
            ->values();
    }

    /**
     * Ambil semua layanan unik yang tersedia di semua RS.
     * Digunakan untuk populate dropdown layanan di form rujukan.
     *
     * @return array<string>
     */
    public function getAllAvailableLayanan(): array
    {
        $layananList = RumahSakit::whereNotNull('layanan_operasi')
            ->pluck('layanan_operasi')
            ->flatMap(fn ($layanan) => is_array($layanan) ? $layanan : json_decode($layanan, true) ?? [])
            ->unique()
            ->sort()
            ->values()
            ->all();

        return $layananList;
    }

    /**
     * Query builder dengan filter JSON_CONTAINS untuk layanan tertentu.
     * Memanfaatkan MySQL JSON function untuk performa.
     */
    private function queryByLayanan(string $layanan): Builder
    {
        return RumahSakit::query()
            ->whereNotNull('layanan_operasi')
            ->whereRaw('JSON_CONTAINS(layanan_operasi, ?)', ['"'.$layanan.'"']);
    }

    /**
     * Haversine formula untuk menghitung jarak antara dua koordinat (km).
     */
    private function haversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
