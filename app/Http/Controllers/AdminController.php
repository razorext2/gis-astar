<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->can('dashboard')) {
            $yearNow = Carbon::today()->year;
            $startDate = Carbon::today()->subDays(6);
            $endDate = Carbon::today();
            $formattedDateRange = $startDate->locale('id')->isoFormat('dddd, D MMM').' - '.$endDate->locale('id')->isoFormat('dddd, D MMM');

            return view('dashboard.dashboard', compact('formattedDateRange', 'yearNow'));
        }

        return view('dashboard.dashboard-user');
    }
}
