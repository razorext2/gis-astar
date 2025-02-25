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
        return view('dashboard.log.index');
    }
}
