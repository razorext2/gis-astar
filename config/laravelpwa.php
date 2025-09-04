<?php

return [
    'name' => 'IndodacinAttendanceSystem',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'Indodacin Attendance',
        'start_url' => '/login',
        'background_color' => '#EF2525',
        'display' => 'standalone',
        'theme_color' => '#EF2525',
        'orientation' => 'any',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/splash-640x1136.png',
            '750x1334' => '/images/icons/splash-750x1334.png',
            '828x1792' => '/images/icons/splash-828x1792.png',
            '1125x2436' => '/images/icons/splash-1125x2436.png',
            '1242x2208' => '/images/icons/splash-1242x2208.png',
            '1242x2688' => '/images/icons/splash-1242x2688.png',
            '1536x2048' => '/images/icons/splash-1536x2048.png',
            '1668x2224' => '/images/icons/splash-1668x2224.png',
            '1668x2388' => '/images/icons/splash-1668x2388.png',
            '2048x2732' => '/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Dashboard',
                'description' => 'Dashboard',
                'url' => '/dashboard',
                'icons' => [
                    "src" => "/images/icons/icon-96x96.png",
                    "purpose" => "any"
                ]
            ]
        ],
        'custom' => [
            'description' => 'Indodacin Attendance adalah aplikasi berbasis web yang dirancang untuk mempermudah absensi karyawan yang berada diluar daerah, serta mempermudah pengarsipan dan pelaporan oleh karyawan.',
            'screenshots' => [
                [
                    'src' => '/images/screenshots/mobile-1.png',
                    'sizes' => '372x806',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                    'label' => 'Form Login'
                ],
                [
                    'src' => '/images/screenshots/mobile-2.png',
                    'sizes' => '372x806',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                    'label' => 'Dashboard Page'
                ],
                [
                    'src' => '/images/screenshots/mobile-3.png',
                    'sizes' => '372x806',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                    'label' => 'Attendance page'
                ],
                [
                    'src' => '/images/screenshots/desktop-1.png',
                    'sizes' => '1366x768',
                    'type' => 'image/png',
                    'form_factor' => 'wide',
                    'label' => 'Form Login'
                ],
                [
                    'src' => '/images/screenshots/desktop-2.png',
                    'sizes' => '1366x768',
                    'type' => 'image/png',
                    'form_factor' => 'wide',
                    'label' => 'Dashboard Page'
                ],
                [
                    'src' => '/images/screenshots/desktop-3.png',
                    'sizes' => '1366x768',
                    'type' => 'image/png',
                    'form_factor' => 'wide',
                    'label' => 'Attendance page'
                ]
            ],
            'display_override' => ['window-controls-overlay'],
        ]
    ]
];
