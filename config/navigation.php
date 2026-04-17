<?php

/**
 * Struktur $menu:
 *
 * Tipe 'link' (menu biasa, tanpa dropdown):
 *   'type'               => 'link'
 *   'label'              => string
 *   'route'              => string
 *   'check'              => array   (route patterns untuk active state)
 *   'icon'               => string  (nama icon component, e.g. 'home', 'camera')
 *   'guard'              => null | ['can', 'permission'] | ['any_permission', [...]] | ['role', [...]]
 *   'navigate'           => bool    (pakai wire:navigate atau tidak)
 *   'counter'            => string|null  (livewire component name)
 *   'counter_permission' => string|null  (permission yg diperlukan untuk tampil counter)
 *
 * Tipe 'group' (menu dengan submenu dropdown):
 *   'type'    => 'group'
 *   'label'   => string
 *   'icon'    => string
 *   'guard'   => null | ['can', '...'] | ['any_permission', [...]] | ['role', [...]]
 *   'submenu' => array of:
 *       'label'              => string
 *       'route'              => string
 *       'check'              => array
 *       'icon'               => string
 *       'permission'         => null | string | array (array = hasAnyPermission)
 *       'navigate'           => bool
 *       'counter'            => string|null
 *       'counter_permission' => string|null
 */

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

    // ─── Absensi ──────────────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Absensi',
        'icon' => 'grid-plus',
        'guard' => null,
        'submenu' => [
            [
                'label' => 'Absensi Hari Ini',
                'mobile_label' => 'Absensi Hari Ini',
                'route' => 'today.attendance',
                'check' => ['today.attendance'],
                'icon' => 'map-pin-alt',
                'permission' => 'pegawai-attendance',
                'navigate' => true,
            ],
            [
                'label' => 'Masuk',
                'mobile_label' => 'Absensi Masuk',
                'route' => 'attendanceIn.index',
                'check' => ['attendanceIn.index'],
                'icon' => 'arrow-left-bracket',
                'navigate' => true,
                'counter' => 'utils.counter.attendance-in-counter',
            ],
            [
                'label' => 'Keluar',
                'mobile_label' => 'Absensi Keluar',
                'route' => 'attendanceOut.index',
                'check' => ['attendanceOut.index'],
                'icon' => 'arrow-right-bracket',
                'navigate' => true,
                'counter' => 'utils.counter.attendance-out-counter',
            ],
        ],
    ],

    // ─── Piutang (Kolektor) ───────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Piutang',
        'icon' => 'wallet',
        'guard' => ['any_permission', ['collect-task-list', 'collect-task-list-ppn', 'collect-idy-ppn-list']],
        'submenu' => [
            [
                'label' => 'IDC Non PPN (SR)',
                'mobile_label' => 'Piutang IDC Non PPN (SR)',
                'route' => 'collect-task.index',
                'check' => ['collect-task.*'],
                'icon' => 'cash',
                'permission' => 'collect-task-list',
                'navigate' => true,
                'counter' => 'utils.counter.collector-idc-non-ppn-counter',
            ],
            [
                'label' => 'IDC PPN (FP)',
                'mobile_label' => 'Piutang IDC PPN (FP)',
                'route' => 'collect-task-ppn.index',
                'check' => ['collect-task-ppn.*'],
                'icon' => 'sale-percent',
                'permission' => 'collect-task-ppn-list',
                'navigate' => true,
                'counter' => 'utils.counter.collector-idc-ppn-counter',
            ],
            [
                'label' => 'IDY PPN (FP)',
                'mobile_label' => 'Piutang IDY PPN (FP)',
                'route' => 'collect-idy-ppn.index',
                'check' => ['collect-idy-ppn.*'],
                'icon' => 'cash-register',
                'permission' => 'collect-idy-ppn-list',
                'navigate' => true,
                'counter' => 'utils.counter.collector-idy-ppn-counter',
            ],
        ],
    ],

    // ─── Manajemen SPK ────────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Manajemen SPK',
        'icon' => 'clipboard-check',
        'guard' => ['any_permission', ['spk-list', 'purchasing-request-list', 'produksi-list', 'spk-update-informasi-pengiriman', 'spk-billing-index', 'laporan-harian-spk-list']],
        'submenu' => [
            [
                'label' => 'Data SPK',
                'mobile_label' => 'Manajemen SPK',
                'route' => 'spk.index',
                'check' => ['spk.*'],
                'icon' => 'cash',
                'permission' => 'spk-list',
                'navigate' => true,
                'counter' => 'utils.counter.spk-main-counter',
            ],
            [
                'label' => 'Purchasing Request',
                'mobile_label' => 'SPK Purchasing Request',
                'route' => 'purchasing-request.index',
                'check' => ['purchasing-request.*'],
                'icon' => 'cash',
                'permission' => 'purchasing-request-list',
                'navigate' => true,
                'counter' => 'utils.counter.spk-purchasing-request-counter',
            ],
            [
                'label' => 'Manajemen Produksi',
                'mobile_label' => 'Manajemen Produksi SPK',
                'route' => 'production.index',
                'check' => ['production.*'],
                'icon' => 'cash',
                'permission' => 'produksi-list',
                'navigate' => true,
                'counter' => 'utils.counter.spk-production-counter',
            ],
            [
                'label' => 'Pengiriman',
                'mobile_label' => 'Manajemen Pengiriman SPK',
                'route' => 'delivery.index',
                'check' => ['delivery.*'],
                'icon' => 'cash',
                'permission' => 'spk-update-informasi-pengiriman',
                'navigate' => true,
                'counter' => 'utils.counter.spk-delivery-counter',
            ],
            [
                'label' => 'Penagihan',
                'mobile_label' => 'Manajemen Penagihan SPK',
                'route' => 'billing.index',
                'check' => ['billing.*'],
                'icon' => 'cash',
                'permission' => ['spk-update-no-tagihan-idcppn', 'spk-update-no-tagihan-idcnonppn', 'spk-update-no-tagihan-idyppn', 'billing-index'],
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Lapangan',
                'mobile_label' => 'Laporan Lapangan SPK',
                'route' => 'daily-report.index',
                'check' => ['daily-report.*'],
                'icon' => 'cash',
                'permission' => 'laporan-harian-spk-list',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Laporan Harian (VT) ──────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Laporan Harian (VT)',
        'icon' => 'chalk-board',
        'guard' => ['can', 'laporan-harian-list'],
        'submenu' => [
            [
                'label' => 'Assign VT',
                'mobile_label' => 'Assign Laporan Harian (VT)',
                'route' => 'report.general.assign',
                'check' => ['report.general.assign'],
                'icon' => 'angle-right',
                'permission' => 'assign-laporan-harian',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Harian',
                'mobile_label' => 'Laporan Harian (VT)',
                'route' => 'report.general.index',
                'check' => ['report.general.index', 'report.general.daily', 'report.general.hourly', 'report.general.customer-assignment'],
                'icon' => 'angle-right',
                'permission' => 'laporan-harian-list',
                'navigate' => true,
                'counter' => 'utils.counter.daily-report-counter',
                'counter_permission' => 'laporan-harian-validate',
            ],
        ],
    ],

    // ─── Rute ─────────────────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Rute',
        'icon' => 'map-pin-alt',
        'guard' => ['any_permission', ['driver-approve', 'collect-approve', 'sales-approve']],
        'submenu' => [
            [
                'label' => 'Driver',
                'mobile_label' => 'Rute Driver',
                'route' => 'routes.driver',
                'check' => ['routes.driver', 'routes.driver.*'],
                'icon' => 'angle-right',
                'permission' => 'driver-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Kolektor',
                'mobile_label' => 'Rute Kolektor',
                'route' => 'routes.collector',
                'check' => ['routes.collector', 'routes.collector.*'],
                'icon' => 'angle-right',
                'permission' => 'collect-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Sales',
                'mobile_label' => 'Rute Sales',
                'route' => 'routes.sales',
                'check' => ['routes.sales', 'routes.sales.*'],
                'icon' => 'angle-right',
                'permission' => 'sales-approve',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Laporan Driver ───────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Laporan Driver',
        'icon' => 'truck',
        'guard' => ['any_permission', ['driver-list']],
        'submenu' => [
            [
                'label' => 'Assign Laporan (SR)',
                'mobile_label' => 'Assign Laporan Driver (SR)',
                'route' => 'driver.assign.add',
                'check' => ['driver.assign.add'],
                'icon' => 'angle-right',
                'permission' => 'driver-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Driver',
                'mobile_label' => 'Laporan Driver',
                'route' => 'driver.index',
                'check' => ['driver.index', 'driver.create', 'driver.show', 'driver.edit', 'driver.assign.to', 'driver.assign.update'],
                'icon' => 'angle-right',
                'permission' => 'driver-list',
                'navigate' => true,
                'counter' => 'utils.counter.driver-counter',
                'counter_permission' => 'driver-approve',
            ],
        ],
    ],

    // ─── Data Invoice ─────────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Data Invoice',
        'icon' => 'rectangle-list',
        'guard' => ['any_permission', ['invoice-list', 'invoice-list-pku', 'invoice-list-jkt']],
        'submenu' => [
            [
                'label' => 'Semua Data',
                'mobile_label' => 'Semua Invoice',
                'route' => 'invoice.all.index',
                'check' => ['invoice.all.*'],
                'icon' => 'file-invoice',
                'permission' => 'invoice-list',
                'navigate' => true,
            ],
            [
                'label' => 'Direct Cust',
                'mobile_label' => 'Direct Cust Invoice',
                'route' => 'invoice.cust.index',
                'check' => ['invoice.cust.*'],
                'icon' => 'file-invoice',
                'permission' => 'invoice-list',
                'navigate' => true,
            ],
            [
                'label' => 'Medan',
                'mobile_label' => 'Invoice Medan',
                'route' => 'invoice.medan.index',
                'check' => ['invoice.medan.*'],
                'icon' => 'file-invoice',
                'permission' => 'invoice-list',
                'navigate' => true,
            ],
            [
                'label' => 'Pekanbaru',
                'mobile_label' => 'Invoice Pekanbaru',
                'route' => 'invoice.pku.index',
                'check' => ['invoice.pku.*'],
                'icon' => 'file-invoice',
                'permission' => 'invoice-list-pku',
                'navigate' => true,
            ],
            [
                'label' => 'Jakarta',
                'mobile_label' => 'Invoice Jakarta',
                'route' => 'invoice.jkt.index',
                'check' => ['invoice.jkt.*'],
                'icon' => 'file-invoice',
                'permission' => 'invoice-list-jkt',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Simple links (formerly $sidebarLinks) ────────────────────────────────
    [
        'type' => 'link',
        'label' => 'Laporan Kolektor',
        'mobile_label' => 'Laporan Kolektor',
        'route' => 'collect.index',
        'check' => ['collect.*'],
        'icon' => 'clipboard',
        'guard' => ['can', 'collect-list'],
        'navigate' => false,
        'counter' => 'utils.counter.collect-counter',
        'counter_permission' => 'collect-approve',
    ],
    [
        'type' => 'link',
        'label' => 'Laporan Sales',
        'mobile_label' => 'Laporan Sales',
        'route' => 'sales.index',
        'check' => ['sales.*'],
        'icon' => 'receipt',
        'guard' => ['can', 'sales-list'],
        'navigate' => true,
        'counter' => 'utils.counter.sales-counter',
        'counter_permission' => 'sales-approve',
    ],
    [
        'type' => 'link',
        'label' => 'Laporan Teknisi',
        'mobile_label' => 'Laporan Teknisi',
        'route' => 'technician.index',
        'check' => ['technician.*'],
        'icon' => 'hammer',
        'guard' => ['can', 'technician-list'],
        'navigate' => true,
        'counter' => 'utils.counter.technician-counter',
        'counter_permission' => 'technician-approve',
    ],
    [
        'type' => 'link',
        'label' => 'Rekam Absensi',
        'mobile_label' => 'Rekam Absensi',
        'route' => 'capture.index',
        'check' => ['capture.index'],
        'icon' => 'camera',
        'guard' => ['can', 'capture'],
        'navigate' => false,
    ],
    [
        'type' => 'link',
        'label' => 'Absensi Rute',
        'mobile_label' => 'Absensi Rute',
        'route' => 'capture.route',
        'check' => ['capture.route'],
        'icon' => 'camera',
        'guard' => ['can', 'capture-route'],
        'navigate' => false,
    ],
    [
        'type' => 'link',
        'label' => 'Pengajuan Cuti',
        'mobile_label' => 'Pengajuan Cuti',
        'route' => 'dayoff.index',
        'check' => ['dayoff.*'],
        'icon' => 'lock-time',
        'guard' => ['can', 'dayoff-list'],
        'navigate' => false,
    ],
    [
        'type' => 'link',
        'label' => 'Pegawai',
        'mobile_label' => 'Manajemen Pegawai',
        'route' => 'pegawai.index',
        'check' => ['pegawai.*'],
        'icon' => 'address-book',
        'guard' => ['can', 'pegawai-list'],
        'navigate' => false,
    ],
    [
        'type' => 'link',
        'label' => 'Jabatan',
        'mobile_label' => 'Manajemen Jabatan',
        'route' => 'jabatan.index',
        'check' => ['jabatan.*'],
        'icon' => 'briefcase',
        'guard' => ['can', 'jabatan-list'],
        'navigate' => false,
    ],
    [
        'type' => 'link',
        'label' => 'Golongan',
        'mobile_label' => 'Manajemen Golongan',
        'route' => 'golongan.index',
        'check' => ['golongan.*'],
        'icon' => 'users-group',
        'guard' => ['can', 'golongan-list'],
        'navigate' => false,
    ],

    // ─── Tim Teknisi ──────────────────────────────────────────────────────────
    [
        'type' => 'link',
        'label' => 'Tim Teknisi',
        'mobile_label' => 'Tim Teknisi',
        'route' => 'teams.index',
        'check' => ['teams.*'],
        'icon' => 'users',
        'guard' => ['can', 'team-list'],
        'navigate' => true,
    ],

    // ─── Lokasi ───────────────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Lokasi',
        'icon' => 'map-pin',
        'guard' => ['any_permission', ['divisi-list', 'placement-list']],
        'submenu' => [
            [
                'label' => 'Divisi',
                'mobile_label' => 'Manajemen Divisi',
                'route' => 'division.index',
                'check' => ['division.*'],
                'icon' => 'object-column',
                'permission' => 'divisi-list',
                'navigate' => true,
            ],
            [
                'label' => 'Penempatan',
                'mobile_label' => 'Manajemen Penempatan',
                'route' => 'placement.index',
                'check' => ['placement.*'],
                'icon' => 'landmark',
                'permission' => 'placement-list',
                'navigate' => true,
            ],
        ],
    ],

    // ─── User Settings ────────────────────────────────────────────────────────
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

    // ─── System Settings ──────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'System Settings',
        'icon' => 'computer',
        'guard' => ['any_permission', ['announcement-list', 'log-list', 'backup-list']],
        'submenu' => [
            [
                'label' => 'Pemberitahuan',
                'mobile_label' => 'Manajemen Pemberitahuan',
                'route' => 'announcement.index',
                'check' => ['announcement.*'],
                'icon' => 'bullhorn',
                'permission' => 'announcement-list',
                'navigate' => true,
            ],
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
                'label' => 'Manajemen Backup',
                'mobile_label' => 'Manajemen Backup',
                'route' => 'backup.index',
                'check' => ['backup.*'],
                'icon' => 'filezip',
                'permission' => 'backup-list',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Transaksi Point ──────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Transaksi Point',
        'icon' => 'wallet',
        'guard' => ['can', 'technician-list'],
        'submenu' => [
            [
                'label' => 'Poin Masuk',
                'mobile_label' => 'Poin Masuk Teknisi',
                'route' => 'points.index',
                'check' => ['points.*'],
                'icon' => 'arrow-right',
                'permission' => 'technician-list',
                'navigate' => true,
            ],
            [
                'label' => 'Poin Keluar',
                'mobile_label' => 'Poin Keluar Teknisi',
                'route' => 'technicianpoints.transactions',
                'check' => ['technicianpoints.*'],
                'icon' => 'arrow-left',
                'permission' => 'point-redeem',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Event ────────────────────────────────────────────────────────────────
    [
        'type' => 'link',
        'label' => 'Event',
        'mobile_label' => 'Manajemen Event',
        'route' => 'event.index',
        'check' => ['event.*'],
        'icon' => 'gift-box',
        'guard' => ['role', ['Admin', 'HRD', 'Management', 'Management-Special']],
        'navigate' => true,
    ],

    // ─── Peta Penyebaran ──────────────────────────────────────────────────────
    [
        'type' => 'link',
        'label' => 'Peta Penyebaran Teknisi',
        'mobile_label' => 'Peta Penyebaran Teknisi',
        'route' => 'map.distribution',
        'check' => ['map.distribution'],
        'icon' => 'book-open',
        'guard' => ['can', 'technician-approve'],
        'navigate' => false,
    ],
];
