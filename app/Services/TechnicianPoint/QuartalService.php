<?php

/** Goal: Quartal date logic + redeem guards, Caller: Redeem.php, Deps: config/quartal.php, PointTransactions, TechnicianPoints */

namespace App\Services\TechnicianPoint;

use App\Models\PointTransactions;
use App\Models\TechnicianPoints;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class QuartalService
{
    /**
     * Get the date range for a specific quarter and year.
     *
     * @return array{from: Carbon, to: Carbon}
     */
    public function getQuartalRange(int $quarter, int $year): array
    {
        $config = config("quartal.quarters.{$quarter}");

        if (! $config) {
            throw new \InvalidArgumentException("Quartal {$quarter} tidak ditemukan di config.");
        }

        $startYear = $config['cross_year'] ? $year - 1 : $year;

        return [
            'from' => Carbon::create($startYear, $config['start_month'], $config['start_day'])->startOfDay(),
            'to' => Carbon::create($year, $config['end_month'], $config['end_day'])->endOfDay(),
        ];
    }

    /**
     * Detect which quarter the current date falls into.
     *
     * @return array{quarter: int, year: int}
     */
    public function getCurrentQuartal(): array
    {
        $today = Carbon::today();

        foreach (config('quartal.quarters') as $q => $cfg) {
            // Try current year first
            $range = $this->getQuartalRange($q, $today->year);
            if ($today->between($range['from'], $range['to'])) {
                return ['quarter' => $q, 'year' => $today->year];
            }

            // For Q1 cross-year, also try next year
            if ($cfg['cross_year']) {
                $range = $this->getQuartalRange($q, $today->year + 1);
                if ($today->between($range['from'], $range['to'])) {
                    return ['quarter' => $q, 'year' => $today->year + 1];
                }
            }
        }

        // Fallback: default to Q1 of current year
        return ['quarter' => 1, 'year' => $today->year];
    }

    /**
     * Check if a quarter has already been redeemed.
     * If kodePegawai is provided, checks per-technician; otherwise checks globally.
     */
    public function isAlreadyRedeemed(int $quarter, int $year, ?string $kodePegawai = null): bool
    {
        $range = $this->getQuartalRange($quarter, $year);

        $query = PointTransactions::where('quartal', $quarter)
            ->where('year', $year)
            ->where('from_date', $range['from']->toDateString())
            ->where('to_date', $range['to']->toDateString())
            ->whereNotIn('status', [4]); // exclude rejected

        if ($kodePegawai) {
            $query->where('kode_pegawai', $kodePegawai);
        }

        return $query->exists();
    }

    /**
     * Get redeemable points within a date range, grouped by kode_pegawai.
     */
    public function getRedeemablePoints(Carbon $from, Carbon $to): Collection
    {
        return TechnicianPoints::whereRaw('DATE(created_at) >= ?', [$from->toDateString()])
            ->whereRaw('DATE(created_at) <= ?', [$to->toDateString()])
            ->where('is_redeemable', 1)
            ->where('is_redeemed', 0)
            ->where('redeemed_status', 0)
            ->orderBy('kode_pegawai')
            ->get()
            ->groupBy('kode_pegawai')
            ->toBase();
    }

    /**
     * Get list of years that have redeemable point data.
     *
     * @return array<int>
     */
    public function getAvailableYears(): array
    {
        $minDate = TechnicianPoints::where('is_redeemable', 1)
            ->min('created_at');

        if (! $minDate) {
            return [now()->year];
        }

        $startYear = Carbon::parse($minDate)->year;
        $endYear = now()->year;

        return range($endYear, $startYear);
    }

    /**
     * Get list of kode_pegawai that are already redeemed in a specific quarter.
     *
     * @return array<string>
     */
    public function getRedeemedPegawaiInQuartal(int $quarter, int $year): array
    {
        $range = $this->getQuartalRange($quarter, $year);

        return PointTransactions::where('quartal', $quarter)
            ->where('year', $year)
            ->where('from_date', $range['from']->toDateString())
            ->where('to_date', $range['to']->toDateString())
            ->whereNotIn('status', [4])
            ->pluck('kode_pegawai')
            ->toArray();
    }
}
