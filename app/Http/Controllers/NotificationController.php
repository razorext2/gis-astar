<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->reorder()
            ->orderByRaw('read_at IS NOT NULL ASC')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.notification.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function fetch()
    {
        $notifications = auth()->user()
            ->unreadNotifications()
            ->take(10)
            ->get();

        if (! $notifications) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        return new ApiResource(true, 'Data berhasil diambil', $notifications);
    }
}
