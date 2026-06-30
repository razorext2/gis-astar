{{-- Goal: Orchestrate report approval popups berdasarkan permission user, Livewire: N/A, Alpine: N/A --}}

@php
    $popups = [];
    $stackIndex = 0;
    $user = auth()->user();

    // Check if leave approval popup has pending items to offset position
    $hasPendingLeave = false;
    if ($user) {
        $hasPendingLeave = \App\Models\LeaveRequest\LeaveRequest::whereIn('status', ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management'])
            ->where(function ($q) use ($user) {
                $q->where(function ($sq) use ($user) {
                    $sq->where('status', 'pending_backup')->where('backup_person_id', $user->id);
                })
                ->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_spv')
                        ->whereHas('user.pegawai.jabatanRelasi.supervisors', fn ($jq) => $jq->where('users.id', $user->id));
                })
                ->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_hrd')
                        ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.hrds', fn ($jq) => $jq->where('users.id', $user->id));
                })
                ->orWhere(function ($sq) use ($user) {
                    $sq->where('status', 'pending_management')
                        ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.managements', fn ($jq) => $jq->where('users.id', $user->id));
                });
            })
            ->exists();
    }

    // Sales — single popup (requires sales-approve)
    if ($user && $user->can('sales-approve')) {
        $popups[] = ['type' => 'sales', 'stack' => $stackIndex++];
    }

    // Driver — single popup (requires driver-approve)
    if ($user && $user->can('driver-approve')) {
        $popups[] = ['type' => 'driver', 'stack' => $stackIndex++];
    }

    // Technician — single popup (requires technician-approve)
    if ($user && $user->can('technician-approve')) {
        $popups[] = ['type' => 'technician', 'stack' => $stackIndex++];
    }

    // Collector — single popup (requires collect-approve)
    if ($user && $user->can('collect-approve')) {
        $popups[] = ['type' => 'collector', 'stack' => $stackIndex++];
    }

    // SPK — single popup (requires spk-approve)
    if ($user && $user->can('spk-approve')) {
        $popups[] = ['type' => 'spk', 'stack' => $stackIndex++];
    }

    // Production — single popup (requires spk-approve, shows SPKs approved but in production)
    if ($user && $user->can('spk-approve')) {
        $popups[] = ['type' => 'production', 'stack' => $stackIndex++];
    }
@endphp

@if (count($popups) > 0)
    <style>
        .report-fab-group {
            pointer-events: none;
            transition: bottom 0.3s ease;
        }
        .report-fab-group.bottom-base {
            bottom: 9.5rem;
        }
        .report-fab-group.bottom-above-leave {
            bottom: 13rem;
        }
        @media (min-width: 768px) {
            .report-fab-group.bottom-base {
                bottom: 6rem;
            }
            .report-fab-group.bottom-above-leave {
                bottom: 9.5rem;
            }
        }
        .report-fab-group .report-fab-item {
            position: absolute;
            bottom: 0;
            right: 0;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease, scale 0.3s ease;
        }
        /* Collapsed state */
        .report-fab-group:not(:hover) .report-fab-item {
            pointer-events: none;
        }
        .report-fab-group:not(:hover) .report-fab-item[data-index="0"] {
            pointer-events: auto;
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        .report-fab-group:not(:hover) .report-fab-item[data-index="1"] {
            opacity: 0.9;
            transform: translateY(-6px) scale(0.92);
        }
        .report-fab-group:not(:hover) .report-fab-item[data-index="2"] {
            opacity: 0.8;
            transform: translateY(-12px) scale(0.84);
        }
        .report-fab-group:not(:hover) .report-fab-item[data-index="3"] {
            opacity: 0.7;
            transform: translateY(-18px) scale(0.76);
        }
        .report-fab-group:not(:hover) .report-fab-item:not([data-index="0"]):not([data-index="1"]):not([data-index="2"]):not([data-index="3"]) {
            opacity: 0;
            transform: translateY(-24px) scale(0.68);
        }

        /* Expanded state on Hover */
        .report-fab-group:hover {
            pointer-events: auto;
        }
        .report-fab-group:hover .report-fab-item {
            pointer-events: auto;
            opacity: 1;
            transform: scale(1);
        }
        .report-fab-group:hover .report-fab-item[data-index="0"] { transform: translateY(0); }
        .report-fab-group:hover .report-fab-item[data-index="1"] { transform: translateY(-3.25rem); }
        .report-fab-group:hover .report-fab-item[data-index="2"] { transform: translateY(-6.5rem); }
        .report-fab-group:hover .report-fab-item[data-index="3"] { transform: translateY(-9.75rem); }
        .report-fab-group:hover .report-fab-item[data-index="4"] { transform: translateY(-13rem); }
        .report-fab-group:hover .report-fab-item[data-index="5"] { transform: translateY(-16.25rem); }
        .report-fab-group:hover .report-fab-item[data-index="6"] { transform: translateY(-19.5rem); }

        /* Z-Index stack ordering */
        .report-fab-item[data-index="0"] { z-index: 60; }
        .report-fab-item[data-index="1"] { z-index: 59; }
        .report-fab-item[data-index="2"] { z-index: 58; }
        .report-fab-item[data-index="3"] { z-index: 57; }
        .report-fab-item[data-index="4"] { z-index: 56; }
        .report-fab-item[data-index="5"] { z-index: 55; }
        .report-fab-item[data-index="6"] { z-index: 54; }
    </style>

    <div class="report-fab-group fixed right-4 z-50 h-11 w-11 md:right-8 {{ $hasPendingLeave ? 'bottom-above-leave' : 'bottom-base' }}">
        @foreach ($popups as $popup)
            <livewire:dashboard.report-approval-popup
                :type="$popup['type']"
                :stackIndex="$popup['stack']"
                :wire:key="'report-popup-' . $popup['type']"
            />
        @endforeach
    </div>
@endif

