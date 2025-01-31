<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('dashboard.notification.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function fetch()
    {
        $notifications = Auth::user()
            ->unreadNotifications()
            ->take(5)
            ->get();

        if (!$notifications) {
            return new ApiResource(false, 'Data tidak ditemukan', null);
        }

        return new ApiResource(true, 'Data berhasil diambil', $notifications);
    }
}
