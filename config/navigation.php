<?php

return [
    // ─── Dashboard ────────────────────────────────────────────────────────────
    [
        'type' => 'link',
        'label' => 'Dashboard',
        'route' => 'dashboard',
        'check' => ['dashboard'],
        'icon' => 'home',
        'guard' => null,
        'navigate' => true,
    ],

    // ─── Manajemen Data ───────────────────────────────────────────────────────
    [
        'type' => 'header',
        'label' => 'Manajemen Data',
    ],
    [
        'type' => 'link',
        'label' => 'Pasien',
        'route' => 'pasien.index',
        'check' => ['pasien.*'],
        'icon' => 'user',
        'guard' => ['any_permission', ['pasien-list']],
        'navigate' => true,
    ],
    [
        'type' => 'link',
        'label' => 'Rumah Sakit Rujukan',
        'route' => 'rs.index',
        'check' => ['rs.*'],
        'icon' => 'office-building',
        'guard' => ['any_permission', ['rs-list']],
        'navigate' => true,
    ],

    // ─── Rujukan ──────────────────────────────────────────────────────────────
    [
        'type' => 'header',
        'label' => 'Rujukan',
    ],
    [
        'type' => 'link',
        'label' => 'Analisis Rujukan',
        'route' => 'rujukan.create',
        'check' => ['rujukan.create'],
        'icon' => 'chart',
        'guard' => ['any_permission', ['rujukan-create', 'rujukan-list']],
        'navigate' => true,
    ],
    [
        'type' => 'link',
        'label' => 'Riwayat Rujukan',
        'route' => 'riwayat.index',
        'check' => ['riwayat.*', 'rujukan.show'],
        'icon' => 'clock',
        'guard' => ['any_permission', ['rujukan-list']],
        'navigate' => true,
    ],
    [
        'type' => 'link',
        'label' => 'Laporan',
        'route' => 'laporan.index',
        'check' => ['laporan.*'],
        'icon' => 'clipboard-list',
        'guard' => ['any_permission', ['rujukan-list']],
        'navigate' => true,
    ],

    // ─── Settings ─────────────────────────────────────────────────────────────
    [
        'type' => 'header',
        'label' => 'Settings',
    ],
    [
        'type' => 'group',
        'label' => 'User Settings',
        'icon' => 'user-setting',
        'guard' => ['any_permission', ['users-list', 'roles-list', 'permissions-list']],
        'submenu' => [
            [
                'label' => 'Users',
                'mobile_label' => 'Manajemen User',
                'route' => 'users.index',
                'check' => ['users.*'],
                'icon' => 'profile-card',
                'permission' => 'users-list',
                'navigate' => true,
            ],
            [
                'label' => 'Roles',
                'mobile_label' => 'Manajemen Role',
                'route' => 'roles.index',
                'check' => ['roles.*'],
                'icon' => 'badge-check',
                'permission' => 'roles-list',
                'navigate' => true,
            ],
            [
                'label' => 'Permissions',
                'mobile_label' => 'Manajemen Permission',
                'route' => 'permissions.index',
                'check' => ['permissions.*'],
                'icon' => 'adjustment',
                'permission' => 'permissions-list',
                'navigate' => true,
            ],
        ],
    ],
    [
        'type' => 'group',
        'label' => 'System Settings',
        'icon' => 'computer',
        'guard' => ['any_permission', ['log-list', 'manage-server']],
        'submenu' => [
            [
                'label' => 'Log Aktivitas',
                'mobile_label' => 'Log Aktivitas',
                'route' => 'log.index',
                'check' => ['log.*'],
                'icon' => 'window',
                'permission' => 'log-list',
                'navigate' => true,
            ],
            [
                'label' => 'Pengaturan Website',
                'mobile_label' => 'Pengaturan Website',
                'route' => 'settings.index',
                'check' => ['settings.*'],
                'icon' => 'adjustment',
                'permission' => 'settings-manage',
                'navigate' => true,
            ],
        ],
    ],
];
