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
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('me', [ProfileController::class, 'show'])->name('profile.me');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Notifications
        Route::resource('notifications', NotificationController::class)->only(['index']);
        Route::get('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');

        // Announcements
        Route::resource('announcement', AnnouncementController::class)->only(['index', 'create', 'edit']);

        // Roles & Permissions & Users
        Route::resource('permissions', PermissionController::class)->only('index', 'create', 'edit');
        Route::resource('roles', RoleController::class)->only('index', 'create', 'edit');
        Route::resource('users', UserController::class)->except('store', 'update');

        // Activity Logs
        Route::get('log', [LoghistoryController::class, 'index'])->name('log.index');
    });
});

require __DIR__.'/auth.php';

// Offline page
// File streaming
Route::get('/file/{path}', function ($path) {
    abort_unless(Storage::exists($path), 404);

    return Storage::response($path);
})->where('path', '.*')->name('file.show');
