<div class="mt-4 flex flex-col gap-6">
    {{-- Header with Quick Info --}}
    <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
        <div class="flex items-center gap-4">
            <x-button.danger wire:navigate href="{{ route('leave-request.my-requests.index') }}"
                class="max-h-10 max-w-fit">
                <x-icons.angle-left class="h-5 w-5" />
            </x-button.danger>

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Detail Pengajuan
                    #{{ $request->id }}</h1>
                <div class="mt-1 flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-500">{{ $request->leaveType->name }}</span>
                    <span class="text-gray-300">•</span>
                    <span class="text-sm font-bold text-primary">{{ $request->total_days }} Hari</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if ($request->status === 'pending_backup')
                <x-button.danger wire:click="cancelRequest"
                    wire:confirm="Apakah Anda yakin ingin membatalkan pengajuan cuti ini?" wire:loading.attr="disabled"
                    wire:target="cancelRequest">
                    <x-slot name="icon">
                        <x-icons.loading wire:loading wire:target="cancelRequest" class="h-4 w-4 animate-spin" />
                        <x-icons.close wire:loading.remove wire:target="cancelRequest" class="h-4 w-4" />
                    </x-slot>

                    <span wire:loading.remove wire:target="cancelRequest">Batalkan Pengajuan</span>
                    <span wire:loading wire:target="cancelRequest">Memproses...</span>
                </x-button.danger>

                <x-button.primary wire:navigate href="{{ route('leave-request.my-requests.edit', $request->id) }}"
                    class="shadow-lg shadow-primary/10">
                    <x-slot name="icon"><x-icons.pen class="h-4 w-4" /></x-slot>
                    Edit
                </x-button.primary>
            @endif
        </div>
    </div>

    {{-- Approval Deadline Countdown --}}
    @if (in_array($request->status, ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management']))
        @php
            $deadlineDays = config('app.leave_approval_deadline_days', 3);
            $deadlineAt = $request->updated_at->copy()->addDays($deadlineDays);
            $hoursRemaining = (int) now()->diffInHours($deadlineAt, false);
            $minutesRemaining = (int) now()->diffInMinutes($deadlineAt, false);
            $isExpired = $hoursRemaining <= 0 && $minutesRemaining <= 0;
            $isUrgent = !$isExpired && $hoursRemaining < 24;
        @endphp

        <div @class([
            'flex items-center gap-3 rounded-xl border px-4 py-3',
            'border-red-200 bg-red-50 dark:border-red-900/30 dark:bg-red-900/10' => $isExpired,
            'border-amber-200 bg-amber-50 dark:border-amber-900/30 dark:bg-amber-900/10' => $isUrgent,
            'border-blue-200 bg-blue-50 dark:border-blue-900/30 dark:bg-blue-900/10' =>
                !$isExpired && !$isUrgent,
        ])>
            <div @class([
                'flex h-9 w-9 shrink-0 items-center justify-center rounded-lg',
                'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' => $isExpired,
                'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' => $isUrgent,
                'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' =>
                    !$isExpired && !$isUrgent,
            ])>
                <x-icons.clock class="h-5 w-5" />
            </div>

            <div class="flex-1">
                <p @class([
                    'text-sm font-bold',
                    'text-red-800 dark:text-red-300' => $isExpired,
                    'text-amber-800 dark:text-amber-300' => $isUrgent,
                    'text-blue-800 dark:text-blue-300' => !$isExpired && !$isUrgent,
                ])>
                    @if ($isExpired)
                        Batas waktu approval telah habis
                    @else
                        Sisa Waktu Approval
                    @endif
                </p>
                <p @class([
                    'text-xs',
                    'text-red-600 dark:text-red-400' => $isExpired,
                    'text-amber-600 dark:text-amber-400' => $isUrgent,
                    'text-blue-600 dark:text-blue-400' => !$isExpired && !$isUrgent,
                ])>
                    @if ($isExpired)
                        Pengajuan ini akan ditolak otomatis oleh sistem.
                    @elseif ($hoursRemaining < 1)
                        {{ $minutesRemaining }} menit lagi — Deadline: {{ $deadlineAt->translatedFormat('d M Y, H:i') }}
                    @elseif ($hoursRemaining < 24)
                        {{ $hoursRemaining }} jam lagi — Deadline: {{ $deadlineAt->translatedFormat('d M Y, H:i') }}
                    @else
                        {{ floor($hoursRemaining / 24) }} hari {{ $hoursRemaining % 24 }} jam lagi — Deadline:
                        {{ $deadlineAt->translatedFormat('d M Y, H:i') }}
                    @endif
                </p>
            </div>

            <span @class([
                'rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider',
                'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' => $isExpired,
                'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' => $isUrgent,
                'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' =>
                    !$isExpired && !$isUrgent,
            ])>
                {{ $deadlineDays }} hari
            </span>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        {{-- Left: Details Card --}}
        <div class="flex flex-col gap-6 lg:col-span-2">
            <x-leave-request.detail-card :request="$request" />
        </div>

        {{-- Right: Timeline --}}
        <div class="flex flex-col gap-6">
            <x-leave-request.timeline :request="$request" />
        </div>
    </div>
</div>
