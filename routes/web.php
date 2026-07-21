<?php

/** Goal: Main Web Routing File, Caller: ServiceProvider */

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\LoghistoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware('throttle:high')->get('/', function () {
    return redirect('login');
})->name('landing.page');

Route::get('/ping', fn () => response()->json(['status' => 'pong', 'timestamp' => now()->timestamp]))->name('ping');

// Route requiring authentication
Route::middleware(['auth'])->group(function () {
    // Push Subscription
    Route::post('/push-subscribe', [PushController::class, 'subscribe']);

    // Notifications API/Read
    Route::get('notifications/{id}/mark-as-read', function ($id) {
        $notification = Auth::user()->unreadNotifications->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return back()->with('success', 'Notification marked as read');
    })->name('notification.mark-as-read');
    Route::get('notifications/fetch', [NotificationController::class, 'fetch'])->name('notification.fetch');

    // Dashboard group
    Route::prefix('dashboard')->as('')->group(function () {
        Route::livewire('/', \App\Livewire\Dashboard::class)->name('dashboard');

        // Profile
        Route::get('me', [ProfileController::class, 'show'])->name('profile.me');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Notifications
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');

        // Announcements
        Route::livewire('announcement', \App\Livewire\PowergridTables\AnnouncementTable::class)->name('announcement.index')->middleware('permission:announcement-list');
        Route::livewire('announcement/create', \App\Livewire\Handler\Announcement\Create::class)->name('announcement.create')->middleware('permission:announcement-create');
        Route::livewire('announcement/{announcement}/edit', \App\Livewire\Handler\Announcement\Edit::class)->name('announcement.edit')->middleware('permission:announcement-edit');

        // Permissions
        Route::livewire('permissions', \App\Livewire\PowergridTables\PermissionsTable::class)->name('permissions.index')->middleware('permission:permissions-list');
        Route::livewire('permissions/create', \App\Livewire\Handler\Permissions\Create::class)->name('permissions.create')->middleware('permission:permissions-create');
        Route::livewire('permissions/{permission}/edit', \App\Livewire\Handler\Permissions\Update::class)->name('permissions.edit')->middleware('permission:permissions-edit');

        // Roles
        Route::livewire('roles', \App\Livewire\PowergridTables\RolesTable::class)->name('roles.index')->middleware('permission:roles-list');
        Route::livewire('roles/create', \App\Livewire\Handler\Roles\Create::class)->name('roles.create')->middleware('permission:roles-create');
        Route::livewire('roles/{role}/edit', \App\Livewire\Handler\Roles\Update::class)->name('roles.edit')->middleware('permission:roles-edit');

        // Users
        Route::livewire('users', \App\Livewire\PowergridTables\UserTable::class)->name('users.index')->middleware('permission:users-list');
        Route::livewire('users/create', \App\Livewire\Handler\User\Create::class)->name('users.create')->middleware('permission:users-create');
        Route::livewire('users/{user}/edit', \App\Livewire\Handler\User\Edit::class)->name('users.edit')->middleware('permission:users-edit');

        // Activity Logs
        Route::livewire('log', \App\Livewire\PowergridTables\LogTable::class)->name('log.index')->middleware('permission:log-list');
    });
});

require __DIR__.'/auth.php';

// Offline page
// File streaming
Route::get('/file/{path}', function ($path) {
    abort_unless(Storage::exists($path), 404);

    return Storage::response($path);
})->where('path', '.*')->name('file.show');
