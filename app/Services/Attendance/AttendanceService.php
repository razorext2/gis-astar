<?php

/** Goal: Provide reusable logic for attendance features, Caller: ApiAttendanceController, AttendanceInquiry components, Today component, Deps: - */

namespace App\Services\Attendance;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AttendanceService
{
    /**
     * Check if coordinates are in Medan boundary.
     */
    public static function isInMedan(?string $latitude, ?string $longitude): bool
    {
        if ($latitude === null || $longitude === null) {
            return false;
        }

        $lat = (float) $latitude;
        $lng = (float) $longitude;

        return $lat >= 3.50 && $lat <= 3.78 && $lng >= 98.58 && $lng <= 98.75;
    }

    /**
     * Resolve a human-readable address from coordinates via Nominatim API.
     * Results are cached for 30 days per coordinate pair.
     */
    public static function fetchAddress(float $lat, float $long): string
    {
        $cacheKey = 'address_lat_long_'.round($lat, 5).'_'.round($long, 5);

        return Cache::remember($cacheKey, 86400 * 30, function () use ($lat, $long) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'IndodacinFaceID/1.1 (indodacinfaceid@gmail.com)',
                ])->timeout(10)->get('https://nominatim.openstreetmap.org/reverse.php', [
                    'lat' => $lat,
                    'lon' => $long,
                    'zoom' => 18,
                    'format' => 'jsonv2',
                ]);

                if ($response->successful()) {
                    return $response->json()['display_name'] ?? 'Alamat tidak ditemukan';
                }

                return 'Gagal mengambil alamat';
            } catch (\Exception $e) {
                Log::error('Gagal fetch alamat: '.$e->getMessage());

                return 'Terjadi kesalahan atau API timeout';
            }
        });
    }
}
