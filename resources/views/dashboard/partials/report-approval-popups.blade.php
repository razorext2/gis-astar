{{-- Goal: Orchestrate report approval popups berdasarkan permission user, Livewire: N/A, Alpine: N/A --}}
{{-- $autoPop: true = auto-open on dashboard, false = FAB only (user must click) --}}
@php $autoPop ??= false; @endphp

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
        if ($user && $user->can($permission) && \App\Livewire\Dashboard\ReportApprovalPopup::hasPendingForUser($user, $type)) {
            $popups[] = [
                'type' => $type,
                'stack' => $stackIndex++,
            ];
        }
    }

    // Assigned Production Tasks (requires assign_to / reassign_to check)
    if ($user) {
        $assignedProductionCount = \App\Models\Spk\Production::where(function ($q) use ($user) {
            $q->where('assign_to', $user->id)->orWhere('reassign_to', $user->id);
        })
            ->whereHas('spk', function ($q) {
                $q->where('status_approval', 1)
                    ->where('on_delay', 0)
                    ->where('is_booked', 0)
                    ->where('is_cancelled', false)
                    ->where('status', '>=', 2);
            })
            ->whereHas('productionHistories', function ($q) {
                $q->where('status_produksi', '>', 0);
            })
            ->whereDoesntHave('productionHistories', function ($q) use ($user) {
                $q->where('added_by', $user->id);
            })
            ->count();

        if ($assignedProductionCount > 0) {
            $popups[] = [
                'type' => 'production-assigned',
                'stack' => $stackIndex++,
                'message' =>
                    'tugas produksi menunggu <span class="font-bold text-zinc-900 dark:text-white">pengerjaan</span> Anda',
            ];
        }
    }

    // Attendance Inquiry Pending (placement-based HRD check)
    if ($user && $user->hasPermissionTo('attendance-inquiry-approve-hrd')) {
        $hasPendingInquiry = \App\Models\AttendanceInquiry\AttendanceInquiry::where('status', 'pending')
            ->whereHas('user.pegawai.jabatanRelasi.placementRelasi.hrds', fn($q) => $q->where('users.id', $user->id))
            ->exists();

        if ($hasPendingInquiry) {
            $popups[] = [
                'type' => 'attendance-inquiry',
                'stack' => $stackIndex++,
            ];
        }
    }
@endphp

@if (count($popups) > 0)
    {{-- Pembungkus relative agar FAB group absolute tidak memengaruhi flex layout --}}
    <div class="relative h-11 w-11" style="overflow: visible;">
    <div x-data="{
        isOpen: false,
        radius: 92, // 5.75rem (92px) radius - sweet spot
        totalPopups: {{ count($popups) }},
        openPopups: {},
        get activeCount() {
            return Object.values(this.openPopups).filter(v => v && v.show).length;
        },
        getTransform(index) {
            if (!this.isOpen) {
                return 'translate(0px, 0px) scale(0.9)';
            }
            let i = index - 1;
            // Spacing: 22 degrees per item starts from 90 (up) to left/down-left
            let angle = 90 + (i * 22);
            let rad = angle * Math.PI / 180;
            let x = Math.round(this.radius * Math.cos(rad));
            let y = Math.round(this.radius * Math.sin(rad));
            return 'translate(' + x + 'px, -' + y + 'px) scale(1)';
        }
    }">
        {{-- FAB Group: absolute bottom-0 right-0 agar keluar dari h-11 w-11 wrapper tanpa memengaruhi flex flow --}}
        <div
            @mouseenter="isOpen = true"
            @mouseleave="isOpen = false"
            @click.away="isOpen = false"
            class="report-fab-group absolute bottom-0 right-0"
            :class="isOpen ? 'w-36 h-36' : 'w-11 h-11'"
            :style="{
                pointerEvents: isOpen ? 'auto' : 'none',
                transition: 'width 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), height 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)'
            }"
            style="overflow: visible;">
            
            @foreach ($popups as $popup)
                <livewire:dashboard.report-approval-popup
                    :type="$popup['type']"
                    :stackIndex="$popup['stack'] + 1"
                    :message="$popup['message'] ?? null"
                    :autoPop="$autoPop"
                    :wire:key="'report-popup-' . $popup['type']" />
            @endforeach

            {{-- Trigger Button (Base) --}}
            <button
                @click="isOpen = !isOpen"
                class="absolute bottom-0 right-0 z-50 bg-white/70 backdrop-blur-md border border-zinc-200/30 dark:border-zinc-800/50 dark:bg-zinc-900/60 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full transition-transform duration-300 hover:scale-105"
                style="pointer-events: auto;">
                <span x-show="!isOpen" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" class="flex items-center justify-center">
                    <x-icons.grid-plus class="h-5 w-5 text-zinc-600 dark:text-zinc-400" />
                </span>
                <span x-show="isOpen" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" class="flex items-center justify-center" style="display: none;">
                    <x-icons.close class="h-5 w-5 text-zinc-600 dark:text-zinc-400" />
                </span>
            </button>
        </div>

        {{-- Backdrop and Grid Overlay --}}
        <div x-show="activeCount > 0" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex flex-col items-center overflow-y-auto bg-zinc-900/60 p-4 backdrop-blur-md lg:p-6"
            x-cloak>

            {{-- Close All Button --}}
            <div class="flex w-full max-w-6xl justify-end pb-4 pt-2 lg:pt-4">
                <button @click="$dispatch('close-all-popups')"
                    class="flex items-center gap-2 rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition-colors hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tutup Semua
                </button>
            </div>

            <div id="report-popup-grid-container"
                class="mb-auto grid w-full justify-center gap-6 pb-8 [grid-template-columns:repeat(auto-fit,23rem)] lg:max-w-6xl lg:pb-12">
                {{-- Teleport target area --}}
            </div>
        </div>
    </div>
    </div>
@endif
