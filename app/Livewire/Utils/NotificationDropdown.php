<?php

namespace App\Livewire\Utils;

use Livewire\Attributes\On;
use Livewire\Component;

class NotificationDropdown extends Component
{
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    #[On('notification-received')]
    public function loadNotifications()
    {
        $user = auth()->user();
        if ($user) {
            $this->unreadCount = $user->unreadNotifications->count();
            $this->notifications = $user->unreadNotifications()->take(10)->get();
        }
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
            $this->dispatch('notification-updated');
        }
    }

    public function render()
    {
        return view('livewire.utils.notification-dropdown');
    }
}
