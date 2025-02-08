<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupController extends Controller
{
    function __construct()
    {
        // $this->middleware("permission:backup-list", ['only' => ['index']]);
    }

    public function index()
    {
        return view('dashboard.backup.index');
    }
}
