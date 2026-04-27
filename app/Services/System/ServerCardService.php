<?php

namespace App\Services\System;

use App\Models\ServerMonitor;

class ServerCardService
{
    public function getServerMonitorCards(): array
    {
        return [
            [
                'permission' => 'manage-server',
                'label' => 'Server Aktif',
                'count' => ServerMonitor::where('is_active', true)->count(),
                'indicator' => 'VM',
                'icon' => 'icons.computer',
                'color' => 'green',
            ],
            [
                'permission' => 'manage-server',
                'label' => 'Server Nonaktif',
                'count' => ServerMonitor::where('is_active', false)->count(),
                'indicator' => 'VM',
                'icon' => 'icons.computer',
                'color' => 'zinc',
            ],
        ];
    }
}
