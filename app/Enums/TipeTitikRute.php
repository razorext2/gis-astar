<?php

namespace App\Enums;

enum TipeTitikRute: string
{
    case Awal = 'awal';
    case Perantara = 'perantara';
    case Tujuan = 'tujuan';

    public function label(): string
    {
        return match ($this) {
            self::Awal => 'Titik Awal (Pasien)',
            self::Perantara => 'Titik Perantara',
            self::Tujuan => 'Tujuan (Rumah Sakit)',
        };
    }
}
