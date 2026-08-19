<?php

namespace App\Services;

use App\Models\RumahSakit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service untuk integrasi dengan OSRM (Open Source Routing Machine) API.
 * Menghitung jarak jalan nyata dan durasi tempuh antarkoordinat berbasis jaringan jalan OpenStreetMap.
 */
class OsrmService
{
    private const DEFAULT_BASE_URL = 'https://router.project-osrm.org';

    private const DEFAULT_TIMEOUT = 6;

    private const CACHE_TTL = 3600; // 1 jam

    private const AVERAGE_SPEED_KMH = 40;

    /**
     * Hitung jarak jalan nyata (km) dan durasi (menit) dari satu titik asal ke banyak titik tujuan sekaligus
     * menggunakan OSRM Table API dalam 1 kali HTTP request.
     *
     * @param  float  $fromLat  Latitude titik asal (pasien)
     * @param  float  $fromLng  Longitude titik asal (pasien)
     * @param  Collection<RumahSakit>|array  $destinations  Daftar rumah sakit tujuan
     * @return array<int, array{distance: float, duration: int, is_road_distance: bool}> Key: id_rumah_sakit
     */
    public function getDistancesAndDurations(
        float $fromLat,
        float $fromLng,
        Collection|array $destinations
    ): array {
        $destCollection = $destinations instanceof Collection ? $destinations : collect($destinations);

        if ($destCollection->isEmpty()) {
            return [];
        }

        $destList = $destCollection->values();
        $cacheKey = $this->generateCacheKey($fromLat, $fromLng, $destList);

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($fromLat, $fromLng, $destList) {
            return $this->fetchFromOsrmTable($fromLat, $fromLng, $destList);
        });
    }

    /**
     * Panggil OSRM Table API untuk mendapatkan matriks jarak dan durasi.
     *
     * @return array<int, array{distance: float, duration: int, is_road_distance: bool}>
     */
    private function fetchFromOsrmTable(float $fromLat, float $fromLng, Collection $destList): array
    {
        $baseUrl = config('services.osrm.base_url', self::DEFAULT_BASE_URL);
        $timeout = (int) config('services.osrm.timeout', self::DEFAULT_TIMEOUT);

        // Koordinat pertama adalah titik asal (pasien)
        $coordinates = ["{$fromLng},{$fromLat}"];

        foreach ($destList as $dest) {
            $lat = $dest instanceof RumahSakit ? $dest->latitude : ($dest['latitude'] ?? 0);
            $lng = $dest instanceof RumahSakit ? $dest->longitude : ($dest['longitude'] ?? 0);
            $coordinates[] = "{$lng},{$lat}";
        }

        $coordString = implode(';', $coordinates);
        $url = "{$baseUrl}/table/v1/driving/{$coordString}?sources=0&annotations=distance,duration";

        $results = [];

        try {
            $response = Http::timeout($timeout)
                ->withHeaders(['User-Agent' => 'GIS-Astar/1.0 (Hospital-Referral)'])
                ->get($url);

            if ($response->successful()) {
                $data = $response->json();
                $distances = $data['distances'][0] ?? [];
                $durations = $data['durations'][0] ?? [];

                foreach ($destList as $index => $dest) {
                    $id = $dest instanceof RumahSakit ? $dest->id_rumah_sakit : ($dest['id_rumah_sakit'] ?? $index);
                    // Index 0 di OSRM table adalah dari source 0 ke source 0, index 1..N adalah ke destinasi 1..N
                    $destIndex = $index + 1;

                    $meters = $distances[$destIndex] ?? null;
                    $seconds = $durations[$destIndex] ?? null;

                    if ($meters !== null && $meters > 0) {
                        $distanceKm = round($meters / 1000, 3);
                        $durationMin = $seconds !== null ? (int) max(1, ceil($seconds / 60)) : (int) ceil(($distanceKm / self::AVERAGE_SPEED_KMH) * 60);

                        $results[$id] = [
                            'distance' => $distanceKm,
                            'duration' => $durationMin,
                            'is_road_distance' => true,
                        ];

                        continue;
                    }

                    // Fallback jika salah satu koordinat tidak dapat rute di OSRM
                    $results[$id] = $this->calculateFallback($fromLat, $fromLng, $dest);
                }

                return $results;
            }
        } catch (\Throwable $e) {
            Log::warning("OSRM Table API gagal ({$e->getMessage()}), beralih ke fallback Haversine.");
        }

        // Fallback untuk semua destinasi jika seluruh request OSRM gagal
        foreach ($destList as $index => $dest) {
            $id = $dest instanceof RumahSakit ? $dest->id_rumah_sakit : ($dest['id_rumah_sakit'] ?? $index);
            $results[$id] = $this->calculateFallback($fromLat, $fromLng, $dest);
        }

        return $results;
    }

    /**
     * Hitung fallback menggunakan formula Haversine garis lurus jika OSRM tidak dapat dihubungi.
     */
    private function calculateFallback(float $fromLat, float $fromLng, RumahSakit|array $dest): array
    {
        $lat = $dest instanceof RumahSakit ? $dest->latitude : ($dest['latitude'] ?? 0);
        $lng = $dest instanceof RumahSakit ? $dest->longitude : ($dest['longitude'] ?? 0);

        $distanceKm = round($this->haversine($fromLat, $fromLng, (float) $lat, (float) $lng), 3);
        $durationMin = (int) max(1, ceil(($distanceKm / self::AVERAGE_SPEED_KMH) * 60));

        return [
            'distance' => $distanceKm,
            'duration' => $durationMin,
            'is_road_distance' => false,
        ];
    }

    /**
     * Formula Haversine untuk jarak garis lurus (km).
     */
    public function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    /**
     * Generate cache key unik berdasarkan titik asal dan daftar ID rumah sakit.
     */
    private function generateCacheKey(float $fromLat, float $fromLng, Collection $destList): string
    {
        $destKeys = $destList->map(function ($d) {
            $id = $d instanceof RumahSakit ? $d->id_rumah_sakit : ($d['id_rumah_sakit'] ?? 0);
            $lat = $d instanceof RumahSakit ? $d->latitude : ($d['latitude'] ?? 0);
            $lng = $d instanceof RumahSakit ? $d->longitude : ($d['longitude'] ?? 0);

            return "{$id}:{$lat},{$lng}";
        })->implode('|');

        $hash = md5("{$fromLat},{$fromLng}_{$destKeys}");

        return "osrm_table_{$hash}";
    }
}
