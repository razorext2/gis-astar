<?php

/** Goal: Halaman monitoring server dengan CRUD dan visualisasi uptime, Caller: ServerOverviewController, Deps: ServerMonitor, ServerMonitorLog */

namespace App\Livewire\System;

use App\Models\ServerMonitor;
use App\Models\ServerMonitorLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Server Overview')]
class ServerOverview extends Component
{
    public $servers = [];
    public $serverId;
    public $name = '';
    public $api_url = '';
    public $is_active = true;
    public $showModal = false;

    public int $page = 1;
    public int $perPage = 3;
    public int $totalServers = 0;

    public function mount(): void
    {
        $this->loadServers();
    }

    public function loadServers(): void
    {
        $this->totalServers = ServerMonitor::count();
        $this->servers = ServerMonitor::orderByDesc('is_active')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }

    public function totalPages(): int
    {
        return (int) ceil($this->totalServers / $this->perPage);
    }

    public function nextPage(): void
    {
        if ($this->page < $this->totalPages()) {
            $this->page++;
            $this->loadServers();
        }
    }

    public function prevPage(): void
    {
        if ($this->page > 1) {
            $this->page--;
            $this->loadServers();
        }
    }

    #[On('open-create-server')]
    public function create(): void
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $server = ServerMonitor::find($id);
        if ($server) {
            $this->serverId = $server->id;
            $this->name = $server->name;
            $this->api_url = $server->api_url;
            $this->is_active = $server->is_active;
            $this->showModal = true;
        }
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'api_url' => 'required|url|max:255',
            'is_active' => 'boolean',
        ]);

        ServerMonitor::updateOrCreate(
            ['id' => $this->serverId],
            [
                'name' => $this->name,
                'api_url' => rtrim($this->api_url, '/'),
                'is_active' => $this->is_active,
            ]
        );

        $this->loadServers();
        $this->showModal = false;
        $this->resetFields();
    }

    public function delete(int $id): void
    {
        ServerMonitor::destroy($id);
        $this->loadServers();
    }

    private function resetFields(): void
    {
        $this->serverId = null;
        $this->name = '';
        $this->api_url = '';
        $this->is_active = true;
    }

    /**
     * Compute 30-day uptime blocks (satu blok = satu hari).
     * Returns array of ['date', 'uptime_pct', 'color', 'has_data']
     */
    public function computeUptimeBlocks(ServerMonitor $server): array
    {
        $window = 30;
        $windowStart = now()->subDays($window)->startOfDay();

        // Load all logs in the window + the last one before the window (for entry status)
        $allLogs = ServerMonitorLog::where('server_monitor_id', $server->id)
            ->where('logged_at', '>=', $windowStart)
            ->orderBy('logged_at')
            ->get();

        $priorLog = ServerMonitorLog::where('server_monitor_id', $server->id)
            ->where('logged_at', '<', $windowStart)
            ->orderByDesc('logged_at')
            ->first();

        $blocks = [];

        for ($i = $window - 1; $i >= 0; $i--) {
            $dayStart = now()->subDays($i)->startOfDay();
            $dayEnd = now()->subDays($i)->endOfDay();

            // Logs during this day
            $dayLogs = $allLogs->filter(
                fn ($l) => $l->logged_at->between($dayStart, $dayEnd)
            )->values();

            // Status at start of this day
            $entryLog = $allLogs
                ->filter(fn ($l) => $l->logged_at < $dayStart)
                ->merge($priorLog ? collect([$priorLog]) : collect())
                ->sortByDesc('logged_at')
                ->first();

            $entryStatus = $entryLog?->status;

            // No data at all
            if (! $entryStatus && $dayLogs->isEmpty()) {
                $blocks[] = [
                    'date' => $dayStart->format('d M'),
                    'uptime_pct' => null,
                    'has_data' => false,
                    'color' => 'bg-zinc-200 dark:bg-zinc-700',
                    'label' => 'Tidak ada data',
                ];
                continue;
            }

            // Calculate uptime ratio for this day
            $uptime = $this->computeDayUptime($entryStatus ?? 'online', $dayLogs, $dayStart, $dayEnd);

            $blocks[] = [
                'date' => $dayStart->format('d M'),
                'uptime_pct' => $uptime,
                'has_data' => true,
                'color' => $this->uptimeColor($uptime),
                'label' => $uptime === 100.0 ? '100% online' : number_format($uptime, 1).'% uptime',
            ];
        }

        return $blocks;
    }

    private function computeDayUptime(string $startStatus, Collection $dayLogs, Carbon $dayStart, Carbon $dayEnd): float
    {
        $totalMinutes = 0;
        $onlineMinutes = 0;
        $currentStatus = $startStatus;
        $currentTime = $dayStart->copy();
        $effectiveEnd = $dayEnd->isFuture() ? now() : $dayEnd;

        foreach ($dayLogs as $log) {
            $seg = (int) $currentTime->diffInMinutes($log->logged_at);
            $totalMinutes += $seg;
            if ($currentStatus === 'online') {
                $onlineMinutes += $seg;
            }
            $currentTime = $log->logged_at->copy();
            $currentStatus = $log->status;
        }

        // Last segment
        $seg = (int) $currentTime->diffInMinutes($effectiveEnd);
        $totalMinutes += $seg;
        if ($currentStatus === 'online') {
            $onlineMinutes += $seg;
        }

        return $totalMinutes > 0
            ? round(($onlineMinutes / $totalMinutes) * 100, 1)
            : 100.0;
    }

    private function uptimeColor(float $pct): string
    {
        if ($pct >= 99) {
            return 'bg-green-500';
        }
        if ($pct >= 90) {
            return 'bg-amber-400';
        }
        if ($pct >= 50) {
            return 'bg-orange-500';
        }

        return 'bg-red-500';
    }

    public function computeUptimePct30Days(ServerMonitor $server): ?float
    {
        $blocks = $this->computeUptimeBlocks($server);
        $dataBlocks = array_filter($blocks, fn ($b) => $b['has_data']);

        if (empty($dataBlocks)) {
            return null;
        }

        return round(collect($dataBlocks)->avg('uptime_pct'), 2);
    }

    public function render()
    {
        return view('livewire.system.server-overview', [
            'servers' => $this->servers,
        ]);
    }
}
