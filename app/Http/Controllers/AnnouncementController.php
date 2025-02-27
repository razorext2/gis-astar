<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:announcement-list', ['index']);
    }

    public function index(Request $request)
    {
        return view('dashboard.announcement.index');
    }
}
