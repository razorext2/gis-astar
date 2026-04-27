<?php

/** Goal: Poll semua server aktif, catat perubahan status, pruning log >30 hari, Caller: Scheduler (everyFiveMinutes), Deps: ServerMonitor, ServerMonitorLog */

namespace App\Console\Commands;

use App\Models\ServerMonitor;
use App\Models\ServerMonitorLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckServerStatus extends Command
{
    protected $signature = 'server:check-status';

    protected $description = 'Poll semua server aktif dan catat perubahan status (online/offline)';

    public function handle(): int
    {
        $servers = ServerMonitor::where('is_active', true)->get();

        if ($servers->isEmpty()) {
            $this->info('Tidak ada server aktif untuk dipantau.');

            return self::SUCCESS;
        }

        foreach ($servers as $server) {
            $this->checkServer($server);
        }

        // Pruning: hapus log lebih dari 30 hari
        $deleted = ServerMonitorLog::where('logged_at', '<', now()->subDays(30))->delete();

        if ($deleted > 0) {
            $this->info("Pruned {$deleted} log entries older than 30 days.");
        }

        return self::SUCCESS;
    }

    private function checkServer(ServerMonitor $server): void
    {
        $start = microtime(true);
        $currentStatus = 'offline';
        $responseTimeMs = null;
        $note = null;

        try {
            $response = Http::timeout(10)->get($server->api_url.'/api/4/cpu');

            if ($response->successful()) {
                $currentStatus = 'online';
                $responseTimeMs = (int) ((microtime(true) - $start) * 1000);
            } else {
                $note = "HTTP {$response->status()}";
            }
        } catch (\Exception $e) {
            $note = $e->getMessage();
        }

        // Ambil log terakhir server ini
        $lastLog = ServerMonitorLog::where('server_monitor_id', $server->id)
            ->orderByDesc('logged_at')
            ->first();

        // Hanya catat jika ada perubahan status (atau pertama kali)
        if (! $lastLog || $lastLog->status !== $currentStatus) {
            ServerMonitorLog::create([
                'server_monitor_id' => $server->id,
                'status' => $currentStatus,
                'response_time_ms' => $responseTimeMs,
                'note' => $note,
                'logged_at' => now(),
            ]);

            $this->info("[{$server->name}] Status berubah: {$currentStatus}" . ($note ? " ({$note})" : ''));
        } else {
            $this->line("[{$server->name}] Status tetap: {$currentStatus}");
        }
    }
}
