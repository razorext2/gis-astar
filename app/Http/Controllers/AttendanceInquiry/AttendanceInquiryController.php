<?php

/** Goal: Handle employee attendance inquiry views, Caller: routes/features/attendance-inquiry.php, Deps: AttendanceInquiry */

namespace App\Http\Controllers\AttendanceInquiry;

use App\Http\Controllers\Controller;
use App\Models\AttendanceInquiry\AttendanceInquiry;
use Illuminate\Support\Facades\Gate;

class AttendanceInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', AttendanceInquiry::class);

        return view('dashboard.attendance-inquiry.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', AttendanceInquiry::class);

        return view('dashboard.attendance-inquiry.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceInquiry $my_inquiry)
    {
        Gate::authorize('view', $my_inquiry);

        return view('dashboard.attendance-inquiry.show', compact('my_inquiry'));
    }
}
