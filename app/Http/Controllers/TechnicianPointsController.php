<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnicianPointsController extends Controller
{
    public function index()
    {
        return view('dashboard.technicianpoints.index');
    }

    public function redeem()
    {
        return view('dashboard.technicianpoints.redeem');
    }

    public function transactions()
    {
        return view('dashboard.technicianpoints.transactions');
    }

    public function detail($transactionID)
    {
        return view('dashboard.technicianpoints.detail-transaction', compact('transactionID'));
    }
}
