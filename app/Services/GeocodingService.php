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
    public function geocode(string $address): ?array
    {
        $cacheKey = 'geocode_fwd_'.md5($address);

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use ($address) {
            try {
                $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
                    ->timeout(5)
                    ->get(self::NOMINATIM_BASE.'/search', [
                        'q' => $address,
                        'format' => 'json',
                        'addressdetails' => 1,
                        'limit' => 1,
                    ]);

                if ($response->successful() && count($response->json()) > 0) {
                    $result = $response->json()[0];

                    return [
                        'lat' => (float) $result['lat'],
                        'lng' => (float) $result['lon'],
                        'display_name' => $result['display_name'],
                    ];
                }
            } catch (\Exception) {
                // Nominatim tidak tersedia
            }

            return null;
        });
    }
}
