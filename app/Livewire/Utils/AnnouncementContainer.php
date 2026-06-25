<?php

/** Goal: Show unread announcements as popup for logged-in users, Caller: layoutsDash/app.blade.php, Deps: Announcement, AnnouncementRead */

namespace App\Livewire\Utils;

use App\Models\Announcement;
use App\Models\AnnouncementRead;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnnouncementContainer extends Component
{
    public ?Announcement $announcement = null;
    public bool $hasRead = false;
    public bool $showModal = false;
    public ?int $announcementId = null;

    public function mount(): void
    {
        $this->loadNextAnnouncement();
    }

    public function loadNextAnnouncement(): void
    {
        $user = Auth::user();

        if (!$user) {
            $this->announcement = null;
            $this->announcementId = null;
            return;
        }

        $roles = $user->roles->pluck('id')->toArray();
        $userId = $user->id;

        $this->announcement = Announcement::where('status', 1)
            ->whereDoesntHave('reads', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where(function ($query) use ($roles, $userId) {
                $query->where('target_type', 'all')
                    ->orWhere(function ($q) use ($roles) {
                        $q->where('target_type', 'role');
                        if (empty($roles)) {
                            $q->whereRaw('1 = 0'); // Jika user tidak punya role, pasti false
                        } else {
                            $q->where(function ($q2) use ($roles) {
                                foreach ($roles as $role) {
                                    $q2->orWhereJsonContains('target_roles', (string)$role);
                                }
                            });
                        }
                    })
                    ->orWhere(function ($q) use ($userId) {
                        $q->where('target_type', 'user')
                            ->whereJsonContains('target_users', (string)$userId);
                    });
            })
            ->first();

        $this->announcementId = $this->announcement?->id;
        $this->hasRead = false;
        
        if ($this->announcement) {
            $this->showModal = true;
        } else {
            $this->showModal = false;
        }
    }

    public function markAsRead(): void
    {
        if ($this->hasRead && $this->announcement) {
            AnnouncementRead::create([
                'announcement_id' => $this->announcement->id,
                'user_id' => auth()->id(),
                'read_at' => now(),
            ]);

            $this->loadNextAnnouncement();
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.utils.announcement-container');
    }
}
