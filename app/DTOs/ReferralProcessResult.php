<?php

namespace App\DTOs;

use App\Models\Rujukan;

/**
 * Value Object untuk hasil keseluruhan proses perujukan.
 * Menggabungkan AStarResult dengan Rujukan yang sudah tersimpan ke DB.
 */
readonly class ReferralProcessResult
{
    public function __construct(
        public AStarResult $astarResult,
        public Rujukan $rujukan,
    ) {}

    public function toArray(): array
    {
        return [
            'astar' => $this->astarResult->toArray(),
            'rujukan' => [
                'id' => $this->rujukan->id_rujukan,
                'no_rujukan' => $this->rujukan->no_rujukan,
                'status' => $this->rujukan->status->value,
                'status_label' => $this->rujukan->status->label(),
            ],
        ];
    }
}
