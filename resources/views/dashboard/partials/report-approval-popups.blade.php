{{-- Goal: Orchestrate report approval popups berdasarkan permission user, Livewire: N/A, Alpine: N/A --}}

@php
    $user = auth()->user();
    $popups = [];
    $stackIndex = 0;

    // Check if leave approval popup has pending items to offset position
    $hasPendingLeave = $user ? \App\Livewire\Dashboard\LeaveApprovalPopup::hasPendingForUser($user) : false;

    // Map of report types and their required permissions
    $reportTypes = [
        'sales' => 'sales-approve',
        'driver' => 'driver-approve',
        'technician' => 'technician-approve',
        'collector' => 'collect-approve',
        'spk' => 'spk-approve',
        'production' => 'spk-approve',
    ];

    foreach ($reportTypes as $type => $permission) {
        if ($user && $user->can($permission)) {
            $popups[] = [
                'type' => $type,
                'stack' => $stackIndex++,
            ];
        }
    }
@endphp

@if (count($popups) > 0)
    <div x-data="{
        openPopups: {},
        get activeCount() {
            return Object.values(this.openPopups).filter(v => v && v.show).length;
        }
    }">
        {{-- FAB Group --}}
        <div
            class="report-fab-group {{ $hasPendingLeave ? 'bottom-above-leave' : 'bottom-base' }} fixed right-4 z-50 h-11 w-11 md:right-8">
            @foreach ($popups as $popup)
                <livewire:dashboard.report-approval-popup :type="$popup['type']" :stackIndex="$popup['stack']"
                    :wire:key="'report-popup-' . $popup['type']" />
            @endforeach
        </div>

        {{-- Backdrop and Grid Overlay --}}
        <div x-show="activeCount > 0" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex justify-center overflow-y-auto bg-zinc-900/60 p-4 backdrop-blur-md lg:p-6"
            x-cloak>
            <div id="report-popup-grid-container"
                class="my-auto grid grid-cols-1 items-stretch justify-center gap-6 py-8 lg:py-12 w-full lg:flex lg:flex-row lg:flex-wrap lg:justify-center lg:max-w-6xl">
                {{-- Teleport target area --}}
            </div>
        </div>
    </div>
@endif
