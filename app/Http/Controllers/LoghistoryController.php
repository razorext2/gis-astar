<?php

namespace App\Http\Controllers;

use App\Models\LogHistory;
use Illuminate\Http\Request;

class LoghistoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:log-list', ['index']);
    }
    public function index()
    {
        // $log = LogHistory::with('userRelasi')
        //     ->orderBy('created_at', 'desc')
        //     ->get();
        // return view('dashboard.log.index', compact('log'));

        return view('dashboard.log.index');
    }
}
