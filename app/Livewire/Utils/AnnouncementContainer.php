<?php

namespace App\Livewire\Utils;

use App\Models\Announcement;
use Livewire\Component;

class AnnouncementContainer extends Component
{
    public function render()
    {
        $row = Announcement::query()->where('status', 1)->first();

        return view('livewire.utils.announcement-container', compact('row'));
    }
}
