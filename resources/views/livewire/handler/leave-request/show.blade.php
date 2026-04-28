<div
    class="mt-4 flex flex-col gap-6 rounded-xl border border-zinc-200 bg-white p-4 shadow-sm backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary md:p-6">
    {{-- Header with Quick Info --}}
    <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
        <div class="flex items-center gap-4">
            <x-button.link wire:navigate href="{{ route('leave-request.my-requests.index') }}"
                class="group rounded-full bg-white !p-2 ring-1 ring-zinc-200 dark:bg-white/5 dark:ring-white/10">
                <x-icons.chevron-left class="h-6 w-6 text-gray-500 transition-colors group-hover:text-primary" />
            </x-button.link>
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
                    wire:confirm="Apakah Anda yakin ingin membatalkan pengajuan cuti ini?"
                    class="shadow-lg shadow-red-500/10 hover:shadow-red-500/20">
                    Batalkan Pengajuan
                </x-button.danger>

                <x-button.primary wire:navigate href="{{ route('leave-request.my-requests.edit', $request->id) }}"
                    class="shadow-lg shadow-primary/10">
                    <x-slot name="icon"><x-icons.pen class="h-4 w-4" /></x-slot>
                    Edit
                </x-button.primary>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        {{-- Left: Details Card --}}
        <div class="flex flex-col gap-6 lg:col-span-2">
            <div
                class="flex flex-col gap-8 rounded-xl border border-zinc-200 bg-white/70 p-8 shadow-md backdrop-blur-2xl dark:border-zinc-800 dark:bg-dark-primary/70">

                {{-- Profile Snippet --}}
                <div
                    class="flex items-center gap-4 rounded-xl border border-zinc-200 bg-gray-50 p-4 dark:border-zinc-800 dark:bg-white/5">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/20 font-bold text-primary">
                        {{ substr($request->user->name, 0, 2) }}
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-tighter text-gray-500">Pemohon</p>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $request->user->name }}
                            ({{ $request->user->kode_pegawai }})</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Waktu Cuti</label>
                        <div class="mt-1 flex items-center gap-3">
                            <div class="rounded-xl bg-primary/10 p-3 text-primary">
                                <x-icons.calendar class="h-6 w-6" />
                            </div>
                            <div>
                                <p class="text-base font-bold text-gray-800 dark:text-white">
                                    {{ $request->start_date->format('d M Y') }} -
                                    {{ $request->end_date->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500">Mulai hari
                                    {{ $request->start_date->isoFormat('dddd') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Personel Backup</label>
                        <div class="mt-1 flex items-center gap-3">
                            <div class="rounded-xl bg-orange-100 p-3 text-orange-600 dark:bg-orange-900/30">
                                <x-icons.user class="h-6 w-6" />
                            </div>
                            <div>
                                <p class="text-base font-bold text-gray-800 dark:text-white">
                                    {{ $request->backupPerson->name ?? 'Tidak Ada' }}</p>
                                <p class="text-xs text-gray-500">Akan menggantikan tugas sementara</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Alasan Pengajuan</label>
                    <div
                        class="rounded-xl border border-zinc-200 bg-gray-50 p-5 italic leading-relaxed text-gray-700 dark:border-zinc-800 dark:bg-white/5 dark:text-gray-300">
                        "{{ $request->reason }}"
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Lampiran Dokumen</label>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        @forelse($request->attachments ?? [] as $path)
                            <a href="{{ route('file.show', ['path' => $path]) }}" target="_blank"
                                class="group flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-zinc-200 p-3 transition-colors hover:border-primary dark:border-zinc-800">
                                <div class="flex min-w-0 items-center gap-3">
                                    <x-icons.paper-clip
                                        class="h-5 w-5 shrink-0 text-gray-400 group-hover:text-primary" />
                                    <span
                                        class="truncate text-sm font-medium text-gray-600 dark:text-gray-400">{{ basename($path) }}</span>
                                </div>
                                <x-icons.chevron-right class="h-4 w-4 shrink-0 text-gray-300" />
                            </a>
                        @empty
                            <p class="text-sm italic text-gray-400">Tidak ada lampiran.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Timeline --}}
        <div class="flex flex-col gap-6">
            <div
                class="rounded-xl border border-zinc-200 bg-white/70 p-8 shadow-md backdrop-blur-2xl dark:border-zinc-800 dark:bg-dark-primary/70">
                <h3 class="mb-8 flex items-center gap-2 text-lg font-bold text-gray-900 dark:text-white">
                    <x-icons.clock class="h-5 w-5 text-primary" />
                    Timeline Approval
                </h3>

                <div class="relative flex flex-col gap-0">
                    {{-- Vertical Line --}}
                    <div class="absolute bottom-2 left-4 top-2 w-0.5 bg-gray-100 dark:bg-white/10"></div>

                    @php
                        $isCanceled = in_array($request->status, ['canceled', 'cancelled']);

                        if ($isCanceled) {
                            $stages = [['key' => 'canceled', 'label' => 'Dibatalkan']];
                        } else {
                            $baseStages = [['key' => 'submitting', 'label' => 'Pengajuan']];
                            if ($request->backup_person_id) {
                                $baseStages[] = ['key' => 'pending_backup', 'label' => 'Persetujuan Backup'];
                            }
                            $baseStages[] = ['key' => 'pending_spv', 'label' => 'Persetujuan SPV'];
                            $baseStages[] = ['key' => 'pending_hrd', 'label' => 'Persetujuan HRD'];
                            $baseStages[] = ['key' => 'pending_management', 'label' => 'Persetujuan Manajemen'];

                            $finalStage =
                                $request->status === 'rejected'
                                    ? ['key' => 'rejected', 'label' => 'Ditolak']
                                    : ['key' => 'approved', 'label' => 'Selesai'];

                            $isFinal = in_array($request->status, ['approved', 'rejected', 'canceled', 'cancelled']);

                            // If canceled, we might want to stop the timeline at the canceling point
                            // But for now, we merge and let the history logic handle icons
                            $stages = array_merge($baseStages, [$finalStage]);
                        }

                        $currentStageIndex = -1;
                        foreach ($stages as $idx => $s) {
                            if ($s['key'] == $request->status) {
                                $currentStageIndex = $idx;
                            }
                        }

                        // Jika status sudah final (approved/rejected/canceled), maka semua stage sebelumnya dianggap "Done"
                        $isFinal = in_array($request->status, ['approved', 'rejected', 'canceled', 'cancelled']);
                        if ($isFinal) {
                            $currentStageIndex = count($stages) - 1;
                        }
                    @endphp

                    @foreach ($stages as $index => $stage)
                        @php
                            // 1. Cari history yang relevan untuk stage ini
                            if ($stage['key'] === 'submitting') {
                                $history = $request->histories->where('action', 'submit')->first();
                            } else {
                                // Cari aksi yang dilakukan SAAT berada di stage ini
                                $history = $request->histories->where('status_from', $stage['key'])->first();

                                // Jika tidak ada, cek apakah ini terminal node (approved/rejected) yang baru saja dicapai
                                if (!$history && in_array($stage['key'], ['approved', 'rejected'])) {
                                    $history = $request->histories->where('status_to', $stage['key'])->first();
                                }
                            }

                            $isDone = $history !== null;
                            $isActive = !$isDone && !$isFinal && $request->status === $stage['key'];
                            $isPending = !$isDone && !$isActive;

                            // Handle Canceled State
                            $wasCanceledHere = $history && in_array($history->status_to, ['canceled', 'cancelled']);
                            $wasRejectedHere = $history && $history->status_to === 'rejected';

                            $isTerminalNode =
                                $wasCanceledHere ||
                                $wasRejectedHere ||
                                ($history && $history->status_to === 'approved');

                            // Colors & Icons
                            $circleColor = 'bg-green-500';
                            if ($wasRejectedHere || $wasCanceledHere) {
                                $circleColor = 'bg-red-500';
                            }
                        @endphp

                        @if ($isDone || $isActive || $index <= $currentStageIndex + 1)
                            <div class="group relative flex gap-4 pb-8">
                                {{-- Circle Indicator --}}
                                <div class="relative z-10">
                                    @if ($isDone)
                                        <div
                                            class="{{ $circleColor }} flex h-8 w-8 items-center justify-center rounded-full text-white ring-4 ring-zinc-50 dark:ring-zinc-900">
                                            @if ($wasRejectedHere || $wasCanceledHere)
                                                <x-icons.close class="h-4 w-4" />
                                            @else
                                                <x-icons.check class="h-4 w-4" />
                                            @endif
                                        </div>
                                    @elseif($isActive)
                                        <div
                                            class="flex h-8 w-8 animate-pulse items-center justify-center rounded-full bg-primary text-white ring-4 ring-primary/20">
                                            <div class="h-2 w-2 rounded-full bg-white"></div>
                                        </div>
                                    @else
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full border border-zinc-200 bg-white text-gray-400 ring-4 ring-transparent dark:border-zinc-800 dark:bg-zinc-900 dark:text-gray-600">
                                            <div class="h-2 w-2 rounded-full bg-current"></div>
                                        </div>
                                    @endif
                                </div>

                                <div class="-mt-0.5 flex flex-col">
                                    <h4
                                        class="{{ $isActive ? 'text-primary' : ($isDone ? 'text-zinc-900 dark:text-white' : 'text-zinc-400') }} text-sm font-bold">
                                        {{ $history ? $history->description : $stage['label'] }}
                                    </h4>
                                    @if ($history)
                                        <div class="mt-1 flex flex-col gap-0.5">
                                            <div class="mb-1">
                                                <span
                                                    class="inline-flex items-center rounded-md bg-zinc-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-zinc-600 dark:bg-white/5 dark:text-zinc-400">
                                                    {{ str_replace('_', ' ', $history->status_from ?? 'Submit') }}
                                                </span>
                                            </div>

                                            <div
                                                class="flex items-center gap-1.5 text-[10px] font-medium text-zinc-500">
                                                <span>{{ $history->actedByUser->name ?? '-' }}</span>
                                                <span>•</span>
                                                <span>{{ $history->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                            @if ($history->note)
                                                <p
                                                    class="mt-1 max-w-xs rounded-xl bg-zinc-50 px-3 py-1.5 text-[10px] italic text-zinc-600 dark:bg-white/5 dark:text-zinc-400">
                                                    "{{ $history->note }}"
                                                </p>
                                            @endif
                                        </div>
                                    @elseif($isActive)
                                        <p class="mt-0.5 text-[10px] font-medium italic text-primary">
                                            Sedang dalam proses...
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($isTerminalNode)
                            @break
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
