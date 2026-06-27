<?php

/** Goal: Define routes for Attendance Inquiry feature, Caller: routes/web.php, Deps: App\Http\Controllers\AttendanceInquiry\AttendanceInquiryController, App\Http\Controllers\AttendanceInquiry\ApprovalCenterController */

use App\Http\Controllers\AttendanceInquiry\ApprovalCenterController;
use App\Http\Controllers\AttendanceInquiry\AttendanceInquiryController;
use Illuminate\Support\Facades\Route;

Route::prefix('attendance-inquiry')
    ->as('attendance-inquiry.')
    ->group(function () {
        Route::resource('my-inquiries', AttendanceInquiryController::class)->only(['index', 'create', 'show']);
        Route::resource('approval-center', ApprovalCenterController::class)->only(['index', 'show']);
    });
