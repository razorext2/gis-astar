<?php

if (!function_exists('countDistance')) {
    /**
     * Haversine distance (km/mi). Returns float (e.g., 12.34).
     * Returns null if any coordinate missing/invalid.
     */
    function countDistance(?float $lat1, ?float $lng1, ?float $lat2, ?float $lng2, string $unit = 'km'): ?float
    {
        // guard: ada nilai null?
        if ($lat1 === null || $lng1 === null || $lat2 === null || $lng2 === null) {
            return null;
        }

        // normalisasi unit
        $u = strtolower($unit);
        $earthRadius = $u === 'mi' || $u === 'mile' ? 3959.0 : 6371.0; // default km

        // konversi derajat → radian
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lng2 - $lng1;

        $a = sin($deltaLat / 2) ** 2
            + cos($lat1) * cos($lat2) * sin($deltaLon / 2) ** 2;

        $c = 2 * asin(sqrt($a));
        $dist = $earthRadius * $c;

        // bulatkan 2 desimal
        return round($dist, 2);
    }
}