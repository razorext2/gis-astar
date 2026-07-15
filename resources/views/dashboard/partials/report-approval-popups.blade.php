{{-- Goal: Orchestrate report approval popups berdasarkan permission user, Livewire: N/A, Alpine: isOpen, activeCount --}}
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
    <div x-data="{
        isOpen: false,
        totalPopups: {{ count($popups) }},
        openPopups: {},
        get activeCount() {
            return Object.values(this.openPopups).filter(v => v && v.show).length;
        }
    }">
        <div
            @click.away="isOpen = false"
            class="relative"
            style="overflow: visible;">

            <button
                @click="isOpen = !isOpen"
                x-data="{ tapping: false }"
                x-on:mousedown="tapping = true"
                x-on:touchstart="tapping = true"
                x-on:animationend="tapping = false"
                :class="[
                    tapping ? 'is-tapping' : '',
                    dynamicBg
                        ? 'bg-glass-light border-glass-border-light backdrop-blur-md shadow-md dark:bg-glass-dark dark:border-glass-border-dark dark:shadow-none'
                        : 'bg-white border-zinc-200 shadow-sm hover:bg-zinc-50 dark:bg-dark-primary dark:border-zinc-800 dark:hover:bg-zinc-800/80'
                ]"
                class="liquid-btn group flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border transition-[background-color,border-color,box-shadow] duration-300 ease-out"
                style="pointer-events: auto;" x-cloak>
                <span x-show="!isOpen" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" class="flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                    <x-icons.grid-plus class="h-5 w-5 text-zinc-600 dark:text-zinc-400" />
                </span>
                <span x-show="isOpen" x-transition:enter="transition duration-200" x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100" class="flex items-center justify-center transition-transform duration-300 group-hover:scale-110" style="display: none;">
                    <x-icons.close class="h-5 w-5 text-zinc-600 dark:text-zinc-400" />
                </span>
            </button>

            {{-- Expanded Items: absolute, vertikal ke atas, di sebelah kiri tombol trigger --}}
            <div class="absolute bottom-0 right-[calc(100%+12px)] flex flex-col-reverse items-end gap-3 pointer-events-none"
                style="overflow: visible;">
                @foreach ($popups as $popup)
                    <livewire:dashboard.report-approval-popup
                        :type="$popup['type']"
                        :stackIndex="$popup['stack'] + 1"
                        :message="$popup['message'] ?? null"
                        :autoPop="$autoPop"
                        :wire:key="'report-popup-' . $popup['type']" />
                @endforeach
            </div>
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
                <x-button.secondary @click="$dispatch('close-all-popups')"
                    class="shadow-none text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white transition-colors duration-200"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
                    <x-slot name="icon">
                        <x-icons.close class="h-4 w-4" />
                    </x-slot>
                    Tutup Semua
                </x-button.secondary>
            </div>

            <div id="report-popup-grid-container"
                class="mb-auto grid w-full justify-center gap-6 pb-8 [grid-template-columns:repeat(auto-fit,23rem)] lg:max-w-6xl lg:pb-12">
                {{-- Teleport target area --}}
            </div>
        </div>
    </div>
@endif
