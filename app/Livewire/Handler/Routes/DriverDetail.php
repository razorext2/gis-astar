<?php

namespace App\Livewire\Handler\Routes;

use App\Models\Pegawai;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class DriverDetail extends Component
{
    #[Locked]
    public int $userId;

    public string $date;

    public function mount(int $userId): void
    {
        $this->userId = $userId;
        $this->date = Carbon::today()->toDateString();
    }

    #[Computed]
    public function pegawai(): Pegawai
    {
        return Pegawai::whereHas('userRelasi', fn ($query) => $query->where('id', $this->userId))->firstOrFail();
    }

    #[Computed]
    public function report()
    {
        return Pegawai::with([
            'driverReport' => function ($query) {
                $query->whereDate('created_at', $this->date)
                    ->orderBy('created_at', 'asc');
            },
        ])
            ->whereHas('userRelasi', fn ($query) => $query->where('id', $this->userId))
            ->firstOrFail()
            ->driverReport;
    }

    /**
     * Return a plain array — @js() will encode it correctly without double-encoding.
     * Filter out records with null coordinates so they don't break OSRM routing.
     */
    #[Computed]
    public function waypoints(): array
    {
        return $this->report
            ->filter(fn ($item) => $item->latitude && $item->longitude)
            ->map(fn ($item) => [
                'id' => $item->id,
                'lat' => (float) $item->latitude,
                'lng' => (float) $item->longitude,
                'name' => $item->title ?? 'N/A',
            ])
            ->values()
            ->all();
    }

    /**
     * When date changes, push fresh waypoints to Alpine via browser event
     * so the map can reinitialize without needing wire:key on the root element.
     */
    public function updatedDate(): void
    {
        $this->dispatch('map-waypoints-updated', waypoints: $this->waypoints);
    }

    public function render()
    {
        return view('livewire.handler.routes.driver-detail');
    }
}
