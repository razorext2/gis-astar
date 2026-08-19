<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Service untuk geocoding menggunakan Nominatim OpenStreetMap API.
 * Semua request di-cache untuk menghindari rate limit Nominatim.
 *
 * Rate limit Nominatim: 1 request/detik untuk penggunaan umum.
 * Cache TTL: 24 jam untuk reverse geocoding, 24 jam untuk forward geocoding.
 */
class GeocodingService
{
    private const NOMINATIM_BASE = 'https://nominatim.openstreetmap.org';

    private const CACHE_TTL_SECONDS = 86400; // 24 jam

    private const USER_AGENT = 'GIS-Astar/1.0 (referral-system)';

    /**
     * Reverse geocoding: koordinat → teks alamat.
     * Result di-cache 24 jam di Redis.
     *
     * @return string Alamat teks, atau koordinat jika gagal
     */
    public function reverseGeocode(float $lat, float $lng): string
    {
        $cacheKey = "geocode_rev_{$lat}_{$lng}";

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use ($lat, $lng) {
            try {
                $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
                    ->timeout(5)
                    ->get(self::NOMINATIM_BASE.'/reverse', [
                        'lat' => $lat,
                        'lon' => $lng,
                        'format' => 'json',
                        'addressdetails' => 1,
                    ]);

                if ($response->successful()) {
                    return $response->json('display_name') ?? "{$lat}, {$lng}";
                }
            } catch (\Exception) {
                // Fallback ke koordinat raw jika Nominatim tidak tersedia
            }

            return "{$lat}, {$lng}";
        });
    }

    /**
     * Forward geocoding: teks alamat → koordinat.
     * Result di-cache 24 jam di Redis.
     *
     * @return array{lat: float, lng: float, display_name: string}|null
     */
    /**
     * Forward geocoding: teks alamat → koordinat.
     * Result di-cache 24 jam di Redis.
     *
     * @return array{lat: float, lng: float, display_name: string}|null
     */
    public function geocode(string $address): ?array
    {
        $results = $this->search($address, 1);

        return $results[0] ?? null;
    }

    /**
     * Search multiple matching addresses with fallback logic.
     *
     * @return array<array{lat: float, lng: float, display_name: string}>
     */
    public function search(string $address, int $limit = 5): array
    {
        $address = trim($address);
        if (empty($address)) {
            return [];
        }

        // 1. Coba cari dengan alamat asli
        $results = $this->queryNominatim($address, $limit);
        if (! empty($results)) {
            return $results;
        }

        // 2. Fallback 1: Hapus nomor rumah/blok/angka detail
        // Contoh: "Jl. Budi Kemasyarakatan No 13D" -> "Jl. Budi Kemasyarakatan"
        $fallback = preg_replace('/\b(no|nomor|no\.|kav|kavling|blok|gang|gg)\s*\w+/i', '', $address);
        // Hapus angka tunggal di akhir/tengah (seperti "13", "13D")
        $fallback = preg_replace('/\b\d+\w*\b/', '', $fallback);
        $fallback = preg_replace('/\s+/', ' ', trim($fallback));

        if (! empty($fallback) && $fallback !== $address) {
            $results = $this->queryNominatim($fallback, $limit);
            if (! empty($results)) {
                return $results;
            }
        }

        // 3. Fallback 2: Hapus kata-kata deskriptif non-standar (bypass, flyover, seberang, dll)
        $cleanFallback = preg_replace('/\b(bypass|flyover|layang|arteri|seberang|depan|dekat|samping|belakang|ujung|gang|gg)\b/i', '', $fallback ?: $address);
        $cleanFallback = preg_replace('/\s+/', ' ', trim($cleanFallback));
        if (! empty($cleanFallback) && $cleanFallback !== $address && $cleanFallback !== $fallback) {
            $results = $this->queryNominatim($cleanFallback, $limit);
            if (! empty($results)) {
                return $results;
            }
        }

        // 4. Fallback 3: Hapus singkatan "jl" / "jalan" untuk mencari kata kunci murni + Medan
        $keywordsOnly = preg_replace('/\b(jl|jalan|jln)\b/i', '', $cleanFallback ?: $address);
        $keywordsOnly = preg_replace('/\s+/', ' ', trim($keywordsOnly));
        if (! empty($keywordsOnly)) {
            if (stripos($keywordsOnly, 'medan') === false) {
                $results = $this->queryNominatim($keywordsOnly.', Medan', $limit);
                if (! empty($results)) {
                    return $results;
                }
            } else {
                $results = $this->queryNominatim($keywordsOnly, $limit);
                if (! empty($results)) {
                    return $results;
                }
            }
        }

        // 5. Fallback 4: Jika query asli tidak mengandung kata "Medan", tambahkan konteks "Medan" ke query awal
        if (stripos($address, 'medan') === false) {
            $results = $this->queryNominatim($address.', Medan', $limit);
            if (! empty($results)) {
                return $results;
            }
        }

        return [];
    }

    /**
     * Query Nominatim API with caching to respect rate limits.
     * strictly bound results to Medan city viewbox.
     *
     * @return array<array{lat: float, lng: float, display_name: string}>
     */
    private function queryNominatim(string $query, int $limit): array
    {
        $cacheKey = 'geocode_nominatim_'.md5($query).'_'.$limit;

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use ($query, $limit) {
            try {
                $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
                    ->timeout(5)
                    ->get(self::NOMINATIM_BASE.'/search', [
                        'q' => $query,
                        'format' => 'json',
                        'addressdetails' => 1,
                        'limit' => $limit,
                        'countrycodes' => 'id',
                        'viewbox' => '98.55,3.69,98.74,3.50',
                        'bounded' => 1,
                    ]);

                if ($response->successful()) {
                    $results = [];
                    foreach ($response->json() as $result) {
                        $results[] = [
                            'lat' => (float) $result['lat'],
                            'lng' => (float) $result['lon'],
                            'display_name' => $result['display_name'],
                        ];
                    }

                    return $results;
                }
            } catch (\Exception) {
                // Nominatim API error/timeout
            }

            return [];
        });
    }
}
