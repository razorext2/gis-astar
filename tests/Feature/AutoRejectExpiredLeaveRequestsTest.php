<?php

/** Goal: Test auto-reject expired leave requests command, Caller: PHPUnit, Deps: LeaveRequest, LeaveRequestHistory */

use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveRequestHistory;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->leaveTypeId = \App\Models\LeaveRequest\LeaveType::first()->id;
});

it('rejects pending leave requests that exceed the deadline', function () {
    config(['app.leave_approval_deadline_days' => 3]);

    $expired = LeaveRequest::withoutEvents(function () {
        return LeaveRequest::create([
            'user_id' => $this->user->id,
            'leave_type_id' => $this->leaveTypeId,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'return_date' => now()->addDays(7),
            'total_days' => 1,
            'reason' => 'Test expired leave',
            'status' => 'pending_backup',
        ]);
    });

    // Manually set updated_at to 4 days ago (beyond 3-day deadline)
    $expired->update(['updated_at' => now()->subDays(4)]);

    $this->artisan('app:auto-reject-expired-leave-requests')
        ->assertExitCode(0);

    expect($expired->fresh()->status)->toBe('rejected');

    $history = LeaveRequestHistory::where('leave_request_id', $expired->id)
        ->where('action', 'auto_reject')
        ->first();

    expect($history)->not->toBeNull()
        ->and($history->status_to)->toBe('rejected')
        ->and($history->note)->toContain('ditolak otomatis');
});

it('does not reject requests still within the deadline', function () {
    config(['app.leave_approval_deadline_days' => 3]);

    $pending = LeaveRequest::withoutEvents(function () {
        return LeaveRequest::create([
            'user_id' => $this->user->id,
            'leave_type_id' => $this->leaveTypeId,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'return_date' => now()->addDays(7),
            'total_days' => 1,
            'reason' => 'Test not expired',
            'status' => 'pending_spv',
        ]);
    });

    // Updated 1 day ago — within deadline
    $pending->update(['updated_at' => now()->subDay()]);

    $this->artisan('app:auto-reject-expired-leave-requests')
        ->assertExitCode(0);

    expect($pending->fresh()->status)->toBe('pending_spv');
});

it('skips already rejected or approved requests', function () {
    config(['app.leave_approval_deadline_days' => 3]);

    $approved = LeaveRequest::withoutEvents(function () {
        return LeaveRequest::create([
            'user_id' => $this->user->id,
            'leave_type_id' => $this->leaveTypeId,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'return_date' => now()->addDays(7),
            'total_days' => 1,
            'reason' => 'Test approved',
            'status' => 'approved',
        ]);
    });

    $approved->update(['updated_at' => now()->subDays(10)]);

    $this->artisan('app:auto-reject-expired-leave-requests')
        ->assertExitCode(0);

    expect($approved->fresh()->status)->toBe('approved');
});

it('outputs info message when no expired requests exist', function () {
    $this->artisan('app:auto-reject-expired-leave-requests')
        ->expectsOutput('Tidak ada pengajuan cuti yang expired.')
        ->assertExitCode(0);
});
