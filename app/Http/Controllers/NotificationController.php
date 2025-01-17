<?php

namespace App\Http\Controllers;

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
}
