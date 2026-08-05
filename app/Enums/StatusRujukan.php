<?php

namespace App\Enums;

enum StatusRujukan: string
{
    case Pending = 'pending';
    case Disetujui = 'disetujui';
    case Ditolak = 'ditolak';
    case Selesai = 'selesai';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Disetujui => 'Disetujui',
            self::Ditolak => 'Ditolak',
            self::Selesai => 'Selesai',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Pending => 'amber',
            self::Disetujui => 'emerald',
            self::Ditolak => 'red',
            self::Selesai => 'blue',
        };
    }
}
