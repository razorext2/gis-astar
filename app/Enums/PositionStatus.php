<?php

/** Goal: Enum posisi pegawai — menggantikan magic number 1/2/3 pada position_status, Caller: Attendance, AttendanceOut, Blade views, Deps: - */

namespace App\Enums;

enum PositionStatus: int
{
    case DalamPerjalanan = 1;
    case StandBy = 2;
    case Onsite = 3;

    public function label(): string
    {
        return match($this) {
            self::DalamPerjalanan => 'Dalam Perjalanan',
            self::StandBy         => 'Stand By',
            self::Onsite          => 'Onsite',
        };
    }

    public function colorClasses(): string
    {
        return match($this) {
            self::DalamPerjalanan => 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200/60 dark:border-amber-900/40',
            self::StandBy         => 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-900/40',
            self::Onsite          => 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-400 border border-rose-200/60 dark:border-rose-900/40',
        };
    }

    public function iconComponent(): string
    {
        return match($this) {
            self::DalamPerjalanan => 'icons.exclamation-circle',
            self::StandBy         => 'icons.check-circle',
            self::Onsite          => 'icons.minus-circle',
        };
    }
}
