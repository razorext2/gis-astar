<?php

namespace App\DTOs;

use App\Enums\TipeTitikRute;

/**
 * Value Object untuk representasi satu titik koordinat geografis.
 */
readonly class GeoPoint
{
    public function __construct(
        public float $lat,
        public float $lng,
        public string $label = '',
        public TipeTitikRute $tipe = TipeTitikRute::Awal,
    ) {}

    public function toArray(): array
    {
        return [
            'lat' => $this->lat,
            'lng' => $this->lng,
            'label' => $this->label,
            'tipe' => $this->tipe->value,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            lat: (float) $data['lat'],
            lng: (float) $data['lng'],
            label: $data['label'] ?? '',
            tipe: TipeTitikRute::from($data['tipe'] ?? 'awal'),
        );
    }
}
