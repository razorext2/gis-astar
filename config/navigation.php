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
 *
 * Tipe 'header' (label grup/spacer):
 *   'type'    => 'header'
 *   'label'   => string
 *   'guard'   => null | ['can', '...'] | ['any_permission', [...]] | ['role', [...]]
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

    // ─── Core Features ────────────────────────────────────────────────────────
    [
        'type' => 'header',
        'label' => 'Core Features',
    ],

    // ─── Absensi ──────────────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Data Absensi',
        'icon' => 'badge-check',
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

    // --- Rekam Absensi
    [
        'type' => 'group',
        'label' => 'Rekam Absensi',
        'icon' => 'camera',
        'guard' => ['any_permission', ['capture', 'capture-route']],
        'submenu' => [
            [
                'label' => 'Rekam Absensi Realtime',
                'mobile_label' => 'Rekam Absensi Realtime',
                'route' => 'capture.index',
                'check' => ['capture.index'],
                'icon' => 'video-camera',
                'permission' => 'capture',
                'navigate' => false,
            ],
            [
                'label' => 'Rekam Absensi Rute',
                'mobile_label' => 'Rekam Absensi Rute',
                'route' => 'capture.route',
                'check' => ['capture.route'],
                'icon' => 'camera',
                'permission' => 'capture-route',
                'navigate' => false,
            ],
        ],
    ],

    // --- Pengajuan Cuti
    [
        'type' => 'group',
        'label' => 'Pengajuan Cuti',
        'icon' => 'envelope',
        'guard' => ['any_permission', ['leave-view-own', 'leave-create', 'leave-approval-center', 'leave-balance-manage']],
        'submenu' => [
            [
                'label' => 'Pengajuan Cuti',
                'mobile_label' => 'Pengajuan Cuti',
                'route' => 'leave-request.my-requests.index',
                'check' => ['leave-request.my-requests.*'],
                'icon' => 'envelope',
                'permission' => 'leave-view-own',
                'navigate' => true,
            ],
            [
                'label' => 'Pengajuan Pinjam Cuti',
                'mobile_label' => 'Pengajuan Pinjam Cuti',
                'route' => 'leave-request.borrow.index',
                'check' => ['leave-request.borrow.*'],
                'icon' => 'calendar',
                'permission' => 'leave-create',
                'navigate' => true,
            ],
            [
                'label' => 'Pusat Approval Cuti',
                'mobile_label' => 'Pusat Approval Cuti',
                'route' => 'leave-request.approval-center.index',
                'check' => ['leave-request.approval-center.*'],
                'icon' => 'command',
                'permission' => 'leave-approval-center',
                'navigate' => true,
                'counter' => 'utils.counter.leave-request-approval-center-counter',
            ],
            [
                'label' => 'Kelola Cuti',
                'mobile_label' => 'Kelola Cuti',
                'route' => 'leave-request.manage.index',
                'check' => ['leave-request.manage.*'],
                'icon' => 'wallet',
                'permission' => 'leave-balance-manage',
                'navigate' => true,
                'counter' => 'utils.counter.leave-request-manage-counter',
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
                'icon' => 'truck',
                'permission' => 'driver-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Kolektor',
                'mobile_label' => 'Rute Kolektor',
                'route' => 'routes.collector',
                'check' => ['routes.collector', 'routes.collector.*'],
                'icon' => 'cash-register',
                'permission' => 'collect-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Sales',
                'mobile_label' => 'Rute Sales',
                'route' => 'routes.sales',
                'check' => ['routes.sales', 'routes.sales.*'],
                'icon' => 'receipt',
                'permission' => 'sales-approve',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Piutang (Kolektor) ───────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Piutang',
        'icon' => 'wallet',
        'guard' => ['any_permission', ['collect-task-list', 'collect-task-ppn-list', 'collect-idy-ppn-list', 'collect-list']],
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
            [
                'label' => 'Laporan Kolektor',
                'mobile_label' => 'Laporan Kolektor',
                'route' => 'collect.index',
                'check' => ['collect.*'],
                'icon' => 'clipboard',
                'permission' => 'collect-list',
                'navigate' => true,
                'counter' => 'utils.counter.collect-counter',
                'counter_permission' => 'collect-approve',
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
                'icon' => 'ordered-list',
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
                'icon' => 'hammer',
                'permission' => 'produksi-list',
                'navigate' => true,
                'counter' => 'utils.counter.spk-production-counter',
            ],
            [
                'label' => 'Pengiriman',
                'mobile_label' => 'Manajemen Pengiriman SPK',
                'route' => 'delivery.index',
                'check' => ['delivery.*'],
                'icon' => 'truck',
                'permission' => 'spk-update-informasi-pengiriman',
                'navigate' => true,
                'counter' => 'utils.counter.spk-delivery-counter',
            ],
            [
                'label' => 'Penagihan',
                'mobile_label' => 'Manajemen Penagihan SPK',
                'route' => 'billing.index',
                'check' => ['billing.*'],
                'icon' => 'cash-register',
                'permission' => ['spk-update-no-tagihan-idcppn', 'spk-update-no-tagihan-idcnonppn', 'spk-update-no-tagihan-idyppn', 'billing-index'],
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Lapangan',
                'mobile_label' => 'Laporan Lapangan SPK',
                'route' => 'daily-report.index',
                'check' => ['daily-report.*'],
                'icon' => 'clipboard-check',
                'permission' => 'laporan-harian-spk-list',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Laporan Harian (VT) ──────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Manajemen Teknisi',
        'icon' => 'person-chalkboard',
        'guard' => ['any_permission', ['laporan-harian-list', 'team-list', 'technician-list', 'assign-laporan-harian']],
        'submenu' => [
            [
                'label' => 'Assign Laporan Harian (VT)',
                'mobile_label' => 'Assign Laporan Harian (VT)',
                'route' => 'report.general.assign',
                'check' => ['report.general.assign'],
                'icon' => 'chalkboard-user',
                'permission' => 'assign-laporan-harian',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Harian',
                'mobile_label' => 'Laporan Harian (VT)',
                'route' => 'report.general.index',
                'check' => ['report.general.index', 'report.general.daily', 'report.general.hourly', 'report.general.customer-assignment'],
                'icon' => 'clipboard',
                'permission' => 'laporan-harian-list',
                'navigate' => true,
                'counter' => 'utils.counter.daily-report-counter',
                'counter_permission' => 'laporan-harian-validate',
            ],
            [
                'label' => 'Tim Teknisi',
                'mobile_label' => 'Tim Teknisi',
                'route' => 'teams.index',
                'check' => ['teams.*'],
                'icon' => 'users-group',
                'permission' => 'team-list',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Teknisi',
                'mobile_label' => 'Laporan Teknisi',
                'route' => 'technician.index',
                'check' => ['technician.*'],
                'icon' => 'clipboard-check',
                'permission' => 'technician-list',
                'navigate' => true,
                'counter' => 'utils.counter.technician-counter',
                'counter_permission' => 'technician-approve',
            ],
        ],
    ],

    // ─── Laporan Driver ───────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Laporan Driver',
        'icon' => 'truck',
        'guard' => ['any_permission', ['driver-list', 'driver-approve']],
        'submenu' => [
            [
                'label' => 'Assign Laporan Driver (SR)',
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
                'icon' => 'truck',
                'permission' => 'driver-list',
                'navigate' => true,
                'counter' => 'utils.counter.driver-counter',
                'counter_permission' => 'driver-approve',
            ],
        ],
    ],

    // ─── Simple links (formerly $sidebarLinks) ────────────────────────────────
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

    // ─── Transaksi Point ──────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Poin Teknisi',
        'icon' => 'wallet',
        'guard' => ['any_permission', ['technician-list', 'point-redeem']],
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

    // ─── Struktural ───────────────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Struktural',
        'icon' => 'map-pin',
        'guard' => ['any_permission', ['divisi-list', 'placement-list', 'jabatan-list', 'golongan-list', 'pegawai-list']],
        'submenu' => [
            [
                'label' => 'Pegawai',
                'mobile_label' => 'Manajemen Pegawai',
                'route' => 'pegawai.index',
                'check' => ['pegawai.*'],
                'icon' => 'address-book',
                'permission' => 'pegawai-list',
                'navigate' => true,
            ],
            [
                'label' => 'Jabatan',
                'mobile_label' => 'Manajemen Jabatan',
                'route' => 'jabatan.index',
                'check' => ['jabatan.*'],
                'icon' => 'briefcase',
                'permission' => 'jabatan-list',
                'navigate' => true,
            ],
            [
                'label' => 'Golongan',
                'mobile_label' => 'Manajemen Golongan',
                'route' => 'golongan.index',
                'check' => ['golongan.*'],
                'icon' => 'users-group',
                'permission' => 'golongan-list',
                'navigate' => true,
            ],
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

    // ─── Laporan Export ───────────────────────────────────────────────────────
    [
        'type' => 'group',
        'label' => 'Laporan',
        'icon' => 'clipboard-list',
        'guard' => ['any_permission', [
            'attendance-approve', 'leave-view-all', 'collect-approve',
            'invoice-add', 'spk-create', 'driver-approve', 'sales-approve',
        ]],
        'submenu' => [
            [
                'label' => 'Laporan Absensi',
                'mobile_label' => 'Laporan Absensi',
                'route' => 'report.export.absensi',
                'check' => ['report.export.absensi'],
                'icon' => 'badge-check',
                'permission' => 'attendance-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Cuti',
                'mobile_label' => 'Laporan Cuti',
                'route' => 'report.export.cuti',
                'check' => ['report.export.cuti'],
                'icon' => 'envelope',
                'permission' => 'leave-view-all',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Piutang',
                'mobile_label' => 'Laporan Piutang',
                'route' => 'report.export.piutang',
                'check' => ['report.export.piutang'],
                'icon' => 'wallet',
                'permission' => 'collect-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Kolektor',
                'mobile_label' => 'Laporan Kolektor',
                'route' => 'report.export.kolektor',
                'check' => ['report.export.kolektor'],
                'icon' => 'cash-register',
                'permission' => 'collect-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Invoice',
                'mobile_label' => 'Laporan Invoice',
                'route' => 'report.export.invoice',
                'check' => ['report.export.invoice'],
                'icon' => 'file-invoice',
                'permission' => 'invoice-add',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan SPK',
                'mobile_label' => 'Laporan SPK',
                'route' => 'report.export.spk',
                'check' => ['report.export.spk'],
                'icon' => 'clipboard-check',
                'permission' => 'spk-create',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Driver',
                'mobile_label' => 'Laporan Driver',
                'route' => 'report.export.driver',
                'check' => ['report.export.driver'],
                'icon' => 'truck',
                'permission' => 'driver-approve',
                'navigate' => true,
            ],
            [
                'label' => 'Laporan Sales',
                'mobile_label' => 'Laporan Sales',
                'route' => 'report.export.sales',
                'check' => ['report.export.sales'],
                'icon' => 'receipt',
                'permission' => 'sales-approve',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Settings ─────────────────────────────────────────────────────────────
    [
        'type' => 'header',
        'label' => 'Settings',
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
        'guard' => ['any_permission', ['announcement-list', 'log-list', 'backup-list', 'holiday-list']],
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
            [
                'label' => 'Manajemen Server',
                'mobile_label' => 'Manajemen Server',
                'route' => 'server.overview',
                'check' => ['server.overview'],
                'icon' => 'computer',
                'permission' => 'manage-server',
                'navigate' => false,
            ],
            [
                'label' => 'Libur Nasional',
                'mobile_label' => 'Libur Nasional',
                'route' => 'system.holidays.index',
                'check' => ['system.holidays.*'],
                'icon' => 'calendar',
                'permission' => 'holiday-list',
                'navigate' => true,
            ],
        ],
    ],

    // ─── Other Features ───────────────────────────────────────────────────────
    [
        'type' => 'header',
        'label' => 'Other Features',
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
