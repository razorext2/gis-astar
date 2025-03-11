<?php

namespace App\Http\Controllers;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:announcement-list', ['index']);
    }

    public function index()
    {
        return view('dashboard.announcement.index');
    }
}
