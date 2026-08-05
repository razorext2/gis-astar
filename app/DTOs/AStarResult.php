<?php

namespace App\DTOs;

use App\Models\RumahSakit;

/**
 * Value Object untuk hasil kalkulasi algoritma A*.
 * Berisi rumah sakit terbaik, semua kandidat terurut, dan metadata rute.
 */
readonly class AStarResult
{
    public function __construct(
        /** Rumah sakit dengan f(n) terkecil */
        public RumahSakit $bestHospital,

        /** Semua kandidat RS diurutkan berdasarkan f(n) terkecil */
        public array $allRanked,

        /** Jarak total dalam kilometer */
        public float $totalDistance,

        /** Estimasi waktu tempuh dalam menit */
        public int $estimatedTime,

        /** Estimasi biaya dalam rupiah */
        public float $estimatedCost,

        /** Waypoints rute: [GeoPoint awal, GeoPoint tujuan] */
        public array $waypoints,

        /** Nama algoritma yang digunakan */
        public string $algorithm = 'astar',

        /** Nilai f(n) dari RS terpilih */
        public float $fScore = 0.0,
    ) {}

    public function toArray(): array
    {
        return [
            'best_hospital' => [
                'id' => $this->bestHospital->id_rumah_sakit,
                'nama' => $this->bestHospital->nama_rumah_sakit,
                'lat' => $this->bestHospital->latitude,
                'lng' => $this->bestHospital->longitude,
            ],
            'all_ranked' => array_map(fn ($item) => [
                'hospital' => [
                    'id' => $item['hospital']->id_rumah_sakit,
                    'nama' => $item['hospital']->nama_rumah_sakit,
                    'lat' => $item['hospital']->latitude,
                    'lng' => $item['hospital']->longitude,
                ],
                'distance' => round($item['distance'], 2),
                'estimated_time' => $item['estimated_time'],
                'estimated_cost' => $item['estimated_cost'],
                'f_score' => round($item['f_score'], 4),
            ], $this->allRanked),
            'total_distance' => $this->totalDistance,
            'estimated_time' => $this->estimatedTime,
            'estimated_cost' => $this->estimatedCost,
            'waypoints' => array_map(fn (GeoPoint $p) => $p->toArray(), $this->waypoints),
            'algorithm' => $this->algorithm,
            'f_score' => $this->fScore,
        ];
    }
}
