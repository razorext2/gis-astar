<?php

if (!function_exists('countDistance')) {
    function countDistance(float $lat1, float $lng1, float $lat2, float $lng2, string $unit = 'km')
    {
        $earthRadius = $unit === 'km' ? 6371 : 3959;

        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $deltaLat = $lat2 - $lat1;
        $deltaLon = $lng2 - $lng1;

        $a = sin($deltaLat / 2) ** 2 +
            cos($lat1) * cos($lat2) *
            sin($deltaLon / 2) ** 2;

        $c = 2 * asin(sqrt($a));
        return round($earthRadius * $c, 2) . $unit;
    }
}