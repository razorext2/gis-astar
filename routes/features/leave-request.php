<?php

/** Goal: Define routes for Leave Request feature, Caller: routes/web.php, Deps: App\Http\Controllers\LeaveRequest\LeaveRequestController */

use App\Http\Controllers\LeaveRequest\ApprovalCenterController;
use App\Http\Controllers\LeaveRequest\LeaveRequestController;
use App\Http\Controllers\LeaveRequest\ManageLeavesController;
use Illuminate\Support\Facades\Route;

Route::prefix('leave-request')
    ->as('leave-request.')
    ->group(function () {
        Route::resource('my-requests', LeaveRequestController::class)->only(['index', 'create', 'edit', 'show']);

        Route::get('borrow', [LeaveRequestController::class, 'borrow'])->name('borrow.index');

        Route::get('stream/pdf/{request}', [LeaveRequestController::class, 'streamPdf'])->name('pdf');

        Route::resource('approval-center', ApprovalCenterController::class)->only(['index', 'create', 'edit', 'show']);

        Route::resource('manage', ManageLeavesController::class)->only(['index']);
    });
