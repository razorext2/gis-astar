<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationBell extends Component
{
    public function render()
    {
        $notification = auth()->user()->unreadNotifications;

        return view('livewire.notification-bell', [
            'notification' => $notification
        ]);
    }
}
