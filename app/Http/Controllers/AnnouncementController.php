<?php

/** Goal: Controller for announcement CRUD routing, Caller: routes/web.php, Deps: Announcement model */

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:announcement-list', ['only' => ['index']]);
        $this->middleware('permission:announcement-create', ['only' => ['create']]);
        $this->middleware('permission:announcement-edit', ['only' => ['edit']]);
    }

    public function index()
    {
        return view('dashboard.announcement.index');
    }

    public function create()
    {
        return view('dashboard.announcement.add');
    }

    public function edit(Announcement $announcement)
    {
        return view('dashboard.announcement.edit', compact('announcement'));
    }
}
