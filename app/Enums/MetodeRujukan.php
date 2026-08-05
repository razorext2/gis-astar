<?php

namespace App\Enums;

enum MetodeRujukan: string
{
    case Manual = 'manual';
    case Otomatis = 'otomatis';

    public function label(): string
    {
        return match ($this) {
            self::Manual => 'Manual',
            self::Otomatis => 'Otomatis (A*)',
        };
    }
}
