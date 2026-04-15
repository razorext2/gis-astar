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
    'mobile' => [
        'icons' => [
            'dayoff' => 'lock-time',
            'collect' => 'clipboard',
            'collect-task' => 'cash',
            'collect-task-ppn' => 'sale-percent',
            'collect-idy-ppn' => 'cash-register',
            'driver' => 'truck',
            'sales' => 'receipt',
            'technician' => 'hammer',
            'capture' => 'camera',
            'pegawai' => 'address-book',
            'jabatan' => 'briefcase',
            'golongan' => 'users-group',
            'division' => 'object-column',
            'placement' => 'landmark',
            'users' => 'profile-card',
            'roles' => 'badge-check',
            'permissions' => 'adjustment',
            'log' => 'window',
            'announcement' => 'bullhorn',
            'backup' => 'filezip',
            'angle-right' => 'angle-right',
            'arrow-right' => 'arrow-right',
            'arrow-left' => 'arrow-left',
            'book-open' => 'book-open',
            'event' => 'gift-box',
            'invoice' => 'file-invoice',
            'daily-report' => 'chalk-board',
            'cash' => 'cash',
        ],
        'links' => [
            [
                'permission' => 'dayoff-list',
                'link' => 'dayoff.index',
                'check' => 'dayoff.*',
                'label' => 'Pengajuan Cuti',
                'icon' => 'dayoff',
            ],
            [
                'permission' => 'collect-task-list',
                'link' => 'collect-task.index',
                'check' => 'collect-task.*',
                'label' => 'IDC Non (SR)',
                'icon' => 'collect-task',
            ],
            [
                'permission' => 'collect-task-ppn-list',
                'link' => 'collect-task-ppn.index',
                'check' => 'collect-task-ppn.*',
                'label' => 'IDC PPN (FP)',
                'icon' => 'collect-task-ppn',
            ],
            [
                'permission' => 'collect-idy-ppn-list',
                'link' => 'collect-idy-ppn.index',
                'check' => 'collect-idy-ppn.*',
                'label' => 'IDY PPN (FP)',
                'icon' => 'collect-idy-ppn',
            ],
            [
                'permission' => 'invoice-list',
                'link' => 'invoice.medan.index',
                'check' => 'invoice.medan.*',
                'label' => 'Laporan Invoice Medan',
                'icon' => 'invoice',
            ],
            [
                'permission' => 'invoice-list-pku',
                'link' => 'invoice.pku.index',
                'check' => 'invoice.pku.*',
                'label' => 'Laporan Invoice PKU',
                'icon' => 'invoice',
            ],
            [
                'permission' => 'invoice-list-jkt',
                'link' => 'invoice.jkt.index',
                'check' => 'invoice.jkt.*',
                'label' => 'Laporan Invoice JKT',
                'icon' => 'invoice',
            ],
            [
                'permission' => 'driver-list',
                'link' => 'driver.index',
                'check' => 'driver.index',
                'label' => 'Laporan Driver',
                'icon' => 'driver',
            ],
            [
                'permission' => 'driver-approve',
                'link' => 'driver.assign.add',
                'check' => 'driver.assign.add',
                'label' => 'Assign Laporan Driver',
                'icon' => 'driver',
            ],
            [
                'permission' => 'collect-list',
                'link' => 'collect.index',
                'check' => 'collect.*',
                'label' => 'Laporan Kolektor',
                'icon' => 'collect',
            ],
            [
                'permission' => 'sales-list',
                'link' => 'sales.index',
                'check' => 'sales.*',
                'label' => 'Laporan Sales',
                'icon' => 'sales',
            ],
            [
                'permission' => 'technician-list',
                'link' => 'technician.index',
                'check' => 'technician.*',
                'label' => 'Laporan Teknisi',
                'icon' => 'technician',
            ],
            // spk
            [
                'permission' => 'spk-list',
                'link' => 'spk.index',
                'check' => 'spk.*',
                'label' => 'Data SPK',
                'icon' => 'invoice',
            ],
            [
                'permission' => 'purchasing-request-list',
                'link' => 'purchasing-request.index',
                'check' => 'purchasing-request.*',
                'label' => 'Purchasing Request',
                'icon' => 'invoice',
            ],
            [
                'permission' => 'produksi-list',
                'link' => 'production.index',
                'check' => 'production.*',
                'label' => 'Manajemen Produksi',
                'icon' => 'invoice',
            ],
            [
                'permission' => 'spk-update-informasi-pengiriman',
                'link' => 'delivery.index',
                'check' => 'delivery.*',
                'label' => 'Pengiriman',
                'icon' => 'driver',
            ],
            [
                'permission' => [
                    'spk-update-no-tagihan-idcppn',
                    'spk-update-no-tagihan-idcnonppn',
                    'spk-update-no-tagihan-idyppn',
                ],
                'link' => 'billing.index',
                'check' => 'billing.*',
                'label' => 'Penagihan',
                'icon' => 'invoice',
            ],
            [
                'permission' => 'laporan-harian-spk-list',
                'link' => 'daily-report.index',
                'check' => 'daily-report.*',
                'label' => 'Laporan Lapangan',
                'icon' => 'cash',
            ],
            // end spk
            // laporan harian
            [
                'permission' => 'assign-laporan-harian',
                'link' => 'report.general.assign',
                'check' => 'report.general.assign',
                'label' => 'Assign Laporan Harian',
                'icon' => 'daily-report',
            ],
            [
                'permission' => 'laporan-harian-list',
                'link' => 'report.general.index',
                'check' => 'report.general.*',
                'label' => 'Laporan Harian',
                'icon' => 'daily-report',
            ],
            // end laporan harian
            [
                'permission' => 'driver-approve',
                'link' => 'routes.driver',
                'check' => 'routes.driver',
                'label' => 'Rute Driver',
                'icon' => 'angle-right',
            ],
            [
                'permission' => 'collect-approve',
                'link' => 'routes.collector',
                'check' => 'routes.collector',
                'label' => 'Rute Kolektor',
                'icon' => 'angle-right',
            ],
            [
                'permission' => 'sales-approve',
                'link' => 'routes.sales',
                'check' => 'routes.sales',
                'label' => 'Rute Sales',
                'icon' => 'angle-right',
            ],
            [
                'permission' => 'capture',
                'link' => 'capture.index',
                'check' => 'capture.index',
                'label' => 'Absensi',
                'icon' => 'capture',
            ],
            [
                'permission' => 'capture-route',
                'link' => 'capture.route',
                'check' => 'capture.route',
                'label' => 'Absensi Rute',
                'icon' => 'capture',
            ],
            [
                'permission' => 'technician-list',
                'link' => 'points.index',
                'check' => 'points.*',
                'label' => 'Poin Masuk',
                'icon' => 'arrow-right',
            ],
            [
                'permission' => 'point-redeem',
                'link' => 'technicianpoints.transactions',
                'check' => 'technicianpoints.*',
                'label' => 'Poin Keluar',
                'icon' => 'arrow-left',
            ],
            [
                'permission' => 'pegawai-list',
                'link' => 'pegawai.index',
                'check' => 'pegawai.*',
                'label' => 'Pegawai',
                'icon' => 'pegawai',
            ],
            [
                'permission' => 'jabatan-list',
                'link' => 'jabatan.index',
                'check' => 'jabatan.*',
                'label' => 'Jabatan',
                'icon' => 'jabatan',
            ],
            [
                'permission' => 'golongan-list',
                'link' => 'golongan.index',
                'check' => 'golongan.*',
                'label' => 'Golongan',
                'icon' => 'golongan',
            ],
            [
                'permission' => 'divisi-list',
                'link' => 'division.index',
                'check' => 'division.*',
                'label' => 'Divisi',
                'icon' => 'division',
            ],
            [
                'permission' => 'placement-list',
                'link' => 'placement.index',
                'check' => 'placement.*',
                'label' => 'Lokasi',
                'icon' => 'placement',
            ],
            [
                'permission' => 'users-list',
                'link' => 'users.index',
                'check' => 'users.*',
                'label' => 'Users',
                'icon' => 'users',
            ],
            [
                'permission' => 'roles-list',
                'link' => 'roles.index',
                'check' => 'roles.*',
                'label' => 'Roles',
                'icon' => 'roles',
            ],
            [
                'permission' => 'permissions-list',
                'link' => 'permissions.index',
                'check' => 'permissions.*',
                'label' => 'Hak Akses',
                'icon' => 'permissions',
            ],
            [
                'permission' => 'log-list',
                'link' => 'log.index',
                'check' => 'log.*',
                'label' => 'Log',
                'icon' => 'log',
            ],
            [
                'permission' => 'announcement-list',
                'link' => 'announcement.index',
                'check' => 'announcement.*',
                'label' => 'Pusat Notifikasi',
                'icon' => 'announcement',
            ],
            [
                'permission' => 'event-manage',
                'link' => 'event.index',
                'check' => 'event.*',
                'label' => 'Event',
                'icon' => 'event',
            ],
            [
                'permission' => 'backup-list',
                'link' => 'backup.index',
                'check' => 'backup.*',
                'label' => 'Manage Backup',
                'icon' => 'backup',
            ],
            [
                'permission' => 'technician-approve',
                'link' => 'map.distribution',
                'check' => 'map.*',
                'label' => 'Peta Penyebaran',
                'icon' => 'book-open',
            ],
        ],
    ],
    'desktop' => [

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
                    'label' => "Today's Attendance",
                    'route' => 'today.attendance',
                    'check' => ['today.attendance'],
                    'icon' => 'map-pin-alt',
                    'permission' => 'pegawai-attendance',
                    'navigate' => true,
                ],
                [
                    'label' => 'Masuk',
                    'route' => 'attendanceIn.index',
                    'check' => ['attendanceIn.index'],
                    'icon' => 'arrow-left-bracket',
                    'navigate' => true,
                    'counter' => 'utils.counter.attendance-in-counter',
                ],
                [
                    'label' => 'Keluar',
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
                    'route' => 'collect-task.index',
                    'check' => ['collect-task.*'],
                    'icon' => 'cash',
                    'permission' => 'collect-task-list',
                    'navigate' => true,
                    'counter' => 'utils.counter.collector-idc-non-ppn-counter',
                ],
                [
                    'label' => 'IDC PPN (FP)',
                    'route' => 'collect-task-ppn.index',
                    'check' => ['collect-task-ppn.*'],
                    'icon' => 'sale-percent',
                    'permission' => 'collect-task-ppn-list',
                    'navigate' => true,
                    'counter' => 'utils.counter.collector-idc-ppn-counter',
                ],
                [
                    'label' => 'IDY PPN (FP)',
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
            'guard' => ['any_permission', ['spk-list', 'purchasing-request-list', 'produksi-list', 'spk-update-informasi-pengiriman']],
            'submenu' => [
                [
                    'label' => 'Data SPK',
                    'route' => 'spk.index',
                    'check' => ['spk.*'],
                    'icon' => 'cash',
                    'permission' => 'spk-list',
                    'navigate' => true,
                    'counter' => 'utils.counter.spk-main-counter',
                ],
                [
                    'label' => 'Purchasing Request',
                    'route' => 'purchasing-request.index',
                    'check' => ['purchasing-request.*'],
                    'icon' => 'cash',
                    'permission' => 'purchasing-request-list',
                    'navigate' => true,
                    'counter' => 'utils.counter.spk-purchasing-request-counter',
                ],
                [
                    'label' => 'Manajemen Produksi',
                    'route' => 'production.index',
                    'check' => ['production.*'],
                    'icon' => 'cash',
                    'permission' => 'produksi-list',
                    'navigate' => true,
                    'counter' => 'utils.counter.spk-production-counter',
                ],
                [
                    'label' => 'Pengiriman',
                    'route' => 'delivery.index',
                    'check' => ['delivery.*'],
                    'icon' => 'cash',
                    'permission' => 'spk-update-informasi-pengiriman',
                    'navigate' => true,
                    'counter' => 'utils.counter.spk-delivery-counter',
                ],
                [
                    'label' => 'Penagihan',
                    'route' => 'billing.index',
                    'check' => ['billing.*'],
                    'icon' => 'cash',
                    'permission' => ['spk-update-no-tagihan-idcppn', 'spk-update-no-tagihan-idcnonppn', 'spk-update-no-tagihan-idyppn'],
                    'navigate' => true,
                ],
                [
                    'label' => 'Laporan Lapangan',
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
                    'route' => 'report.general.assign',
                    'check' => ['report.general.assign'],
                    'icon' => 'angle-right',
                    'permission' => 'assign-laporan-harian',
                    'navigate' => true,
                ],
                [
                    'label' => 'Laporan Harian',
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
                    'route' => 'routes.driver',
                    'check' => ['routes.driver', 'routes.driver.*'],
                    'icon' => 'angle-right',
                    'permission' => 'driver-approve',
                    'navigate' => true,
                ],
                [
                    'label' => 'Kolektor',
                    'route' => 'routes.collector',
                    'check' => ['routes.collector', 'routes.collector.*'],
                    'icon' => 'angle-right',
                    'permission' => 'collect-approve',
                    'navigate' => true,
                ],
                [
                    'label' => 'Sales',
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
                    'route' => 'driver.assign.add',
                    'check' => ['driver.assign.add'],
                    'icon' => 'angle-right',
                    'permission' => 'driver-approve',
                    'navigate' => true,
                ],
                [
                    'label' => 'Laporan Driver',
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
                    'route' => 'invoice.all.index',
                    'check' => ['invoice.all.*'],
                    'icon' => 'file-invoice',
                    'permission' => 'invoice-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Direct Cust',
                    'route' => 'invoice.cust.index',
                    'check' => ['invoice.cust.*'],
                    'icon' => 'file-invoice',
                    'permission' => 'invoice-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Medan',
                    'route' => 'invoice.medan.index',
                    'check' => ['invoice.medan.*'],
                    'icon' => 'file-invoice',
                    'permission' => 'invoice-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Pekanbaru',
                    'route' => 'invoice.pku.index',
                    'check' => ['invoice.pku.*'],
                    'icon' => 'file-invoice',
                    'permission' => 'invoice-list-pku',
                    'navigate' => true,
                ],
                [
                    'label' => 'Jakarta',
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
            'label' => 'Record Attendance',
            'route' => 'capture.index',
            'check' => ['capture.index'],
            'icon' => 'camera',
            'guard' => ['can', 'capture'],
            'navigate' => false,
        ],
        [
            'type' => 'link',
            'label' => 'Absen Rute',
            'route' => 'capture.route',
            'check' => ['capture.route'],
            'icon' => 'camera',
            'guard' => ['can', 'capture-route'],
            'navigate' => false,
        ],
        [
            'type' => 'link',
            'label' => 'Pengajuan Off',
            'route' => 'dayoff.index',
            'check' => ['dayoff.*'],
            'icon' => 'lock-time',
            'guard' => ['can', 'dayoff-list'],
            'navigate' => false,
        ],
        [
            'type' => 'link',
            'label' => 'Pegawai',
            'route' => 'pegawai.index',
            'check' => ['pegawai.*'],
            'icon' => 'address-book',
            'guard' => ['can', 'pegawai-list'],
            'navigate' => false,
        ],
        [
            'type' => 'link',
            'label' => 'Jabatan',
            'route' => 'jabatan.index',
            'check' => ['jabatan.*'],
            'icon' => 'briefcase',
            'guard' => ['can', 'jabatan-list'],
            'navigate' => false,
        ],
        [
            'type' => 'link',
            'label' => 'Golongan',
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
                    'route' => 'division.index',
                    'check' => ['division.*'],
                    'icon' => 'object-column',
                    'permission' => 'divisi-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Penempatan',
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
                    'route' => 'users.index',
                    'check' => ['users.*'],
                    'icon' => 'profile-card',
                    'permission' => 'users-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Roles',
                    'route' => 'roles.index',
                    'check' => ['roles.*'],
                    'icon' => 'badge-check',
                    'permission' => 'roles-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Permissions',
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
                    'route' => 'announcement.index',
                    'check' => ['announcement.*'],
                    'icon' => 'bullhorn',
                    'permission' => 'announcement-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Log Aktivitas',
                    'route' => 'log.index',
                    'check' => ['log.*'],
                    'icon' => 'window',
                    'permission' => 'log-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Manage Backups',
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
                    'route' => 'points.index',
                    'check' => ['points.*'],
                    'icon' => 'arrow-right',
                    'permission' => 'technician-list',
                    'navigate' => true,
                ],
                [
                    'label' => 'Poin Keluar',
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
            'route' => 'map.distribution',
            'check' => ['map.distribution'],
            'icon' => 'book-open',
            'guard' => ['can', 'technician-approve'],
            'navigate' => false,
        ],

    ],
];
