<?php

/** Goal: Handle HRD/Management attendance inquiry approval views, Caller: routes/features/attendance-inquiry.php, Deps: AttendanceInquiry */

namespace App\Http\Controllers\AttendanceInquiry;

use App\Http\Controllers\Controller;
use App\Models\AttendanceInquiry\AttendanceInquiry;
use Illuminate\Support\Facades\Gate;

class ApprovalCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', AttendanceInquiry::class);

        return view('dashboard.attendance-inquiry.approval-center.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceInquiry $approval_center)
    {
        Gate::authorize('view', $approval_center);

        return view('dashboard.attendance-inquiry.approval-center.show', [
            'inquiry' => $approval_center,
        ]);
    }
}
