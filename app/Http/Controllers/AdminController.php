<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceOut;
use App\Models\Pegawai;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        if (auth()->user()->can('dashboard')) {
            $today = Carbon::today();

            $startDate = Carbon::today()->subDays(6);
            $endDate = Carbon::today();
            $formattedDateRange = $startDate->locale('id')->isoFormat('dddd, D MMM') . ' - ' . $endDate->locale('id')->isoFormat('dddd, D MMM');

            $yearNow = Carbon::today()->year;

            $attendance_out_today = AttendanceOut::whereDate('jam_keluar', $today)
                ->with('pegawaiRelasi')
                ->orderBy('jam_keluar', 'desc')
                ->get();

            $attendance_today = Attendance::whereDate('jam_masuk', $today)
                ->with('pegawaiRelasi')
                ->orderBy('jam_masuk', 'desc')
                ->get();

            return view('dashboard.dashboard', compact('attendance_today', 'attendance_out_today', 'formattedDateRange', 'yearNow'));
        } else {
            $getDay = Carbon::today()->locale('id')->isoFormat('dddd');
            $today = Carbon::today();

            $salesBaseQuery = Sales::where('kode_pegawai', auth()->user()->kode_pegawai)->get();

            // Total sales
            $sales_total = $salesBaseQuery->count();
            $sales_approved = $salesBaseQuery->where('status', 1)->count();
            $sales_approved_percentage = $sales_total > 0 ? $sales_approved / $sales_total * 100 : 0;

            // Harian
            $startDay = Carbon::now()->startOfDay();
            $endDay = Carbon::now()->endOfDay();
            $sales_total_daily = $salesBaseQuery->whereBetween('created_at', [$startDay, $endDay])->count();
            $sales_approved_daily = $salesBaseQuery->whereBetween('created_at', [$startDay, $endDay])->where('status', 1)->count();
            $sales_approved_percentage_daily = $sales_total_daily > 0 ? $sales_approved_daily / $sales_total_daily * 100 : 0;

            // Bulanan
            $startMonth = Carbon::now()->startOfMonth();
            $endMonth = Carbon::now()->endOfMonth();

            $sales_total_monthly = $salesBaseQuery->whereBetween('created_at', [$startMonth, $endMonth])->count();
            $sales_approved_monthly = $salesBaseQuery->whereBetween('created_at', [$startMonth, $endMonth])->where('status', 1)->count();
            $sales_approved_percentage_monthly = $sales_total_monthly > 0 ? $sales_approved_monthly / $sales_total_monthly * 100 : 0;

            // Get Pegawai with related Jadwal for today’s day of the week
            $getPegawai = Pegawai::with([
                'jadwalRelasi' => function ($query) use ($getDay) {
                    $query->where('hari', $getDay);
                }
            ])
                ->where('kode_pegawai', Auth::user()->kode_pegawai)
                ->first();

            // Get today's Jadwal if available
            $getJadwal = $getPegawai?->jadwalRelasi->first();

            $attendance_all = Pegawai::with([
                'attendanceRelasi' => function ($query) use ($today) {
                    $query->whereDate('jam_masuk', $today);
                },
                'latestAttendanceOutRelasi'
            ])
                ->select('kode_pegawai', 'nick_name')
                ->where('kode_pegawai', Auth::user()->kode_pegawai)
                ->get()
                ->map(function ($pegawai) {
                    return [
                        'kode_pegawai' => $pegawai->kode_pegawai,
                        'nick_name' => $pegawai->nick_name,
                        'jam_masuk' => $pegawai->attendanceRelasi->first()->jam_masuk ?? null,
                        'latest_jam_keluar' => $pegawai->latestAttendanceOutRelasi->jam_keluar ?? null,
                    ];
                })
                ->sortBy(function ($pegawai) {
                    // Sort by jam_masuk ascending (nulls last) and then by latest_jam_keluar descending (nulls last)
                    return [
                        $pegawai['latest_jam_keluar'] ? -$pegawai['latest_jam_keluar']->timestamp : PHP_INT_MAX,  // Sort latest_jam_keluar descending (nulls last)
                        $pegawai['jam_masuk'] ? $pegawai['jam_masuk']->timestamp : PHP_INT_MAX  // Sort jam_masuk ascending (nulls last)
                    ];
                });

            return view('dashboard.dashboard-user', compact(['getDay', 'getJadwal', 'attendance_all', 'sales_total', 'sales_approved', 'sales_approved_percentage', 'sales_total_daily', 'sales_approved_daily', 'sales_approved_percentage_daily', 'sales_total_monthly', 'sales_approved_monthly', 'sales_approved_percentage_monthly']));
        }
    }
}
