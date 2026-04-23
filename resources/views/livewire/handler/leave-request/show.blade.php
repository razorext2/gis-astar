<div
    class="mt-4 flex flex-col gap-6 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm backdrop-blur-xl dark:bg-dark-primary dark:border-gray-700 md:p-6">
    {{-- Header with Quick Info --}}
    <div class="flex flex-col justify-between gap-6 md:flex-row md:items-center">
        <div class="flex items-center gap-4">
            <x-button.link wire:navigate href="{{ route('leave-request.my-requests.index') }}"
                class="group rounded-full bg-white !p-2 ring-1 ring-gray-200 dark:bg-white/5 dark:ring-white/10">
                <x-icons.chevron-left class="group-hover:text-primary h-6 w-6 text-gray-500 transition-colors" />
            </x-button.link>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Detail Pengajuan
                    #{{ $request->id }}</h1>
                <div class="mt-1 flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-500">{{ $request->leave_type->name }}</span>
                    <span class="text-gray-300">•</span>
                    <span class="text-primary text-sm font-bold">{{ $request->total_days }} Hari</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if (in_array($request->status, ['pending_backup', 'pending_spv']))
                <x-button.danger class="shadow-lg shadow-red-500/10 hover:shadow-red-500/20">
                    Batalkan Pengajuan
                </x-button.danger>
            @endif
            <x-button.primary wire:navigate href="{{ route('leave-request.my-requests.edit', $request->id) }}"
                class="shadow-primary/10 shadow-lg">
                <x-slot name="icon"><x-icons.pen class="h-4 w-4" /></x-slot>
                Edit
            </x-button.primary>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        {{-- Left: Details Card --}}
        <div class="flex flex-col gap-6 lg:col-span-2">
            <div
                class="flex flex-col gap-8 rounded-[2rem] border border-gray-200 bg-white/70 p-8 shadow-xl backdrop-blur-2xl dark:border-gray-700 dark:bg-dark-primary/70">

                {{-- Profile Snippet --}}
                <div
                    class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-white/5">
                    <div
                        class="bg-primary/20 text-primary flex h-12 w-12 items-center justify-center rounded-full font-bold">
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
                            <div class="bg-primary/10 text-primary rounded-xl p-3">
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
                                    {{ $request->backup_person->name }}</p>
                                <p class="text-xs text-gray-500">Akan menggantikan tugas sementara</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Alasan Pengajuan</label>
                    <div
                        class="rounded-2xl border border-gray-200 bg-gray-50 p-5 italic leading-relaxed text-gray-700 dark:border-gray-700 dark:bg-white/5 dark:text-gray-300">
                        "{{ $request->reason }}"
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Lampiran Dokumen</label>
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                        <div
                            class="hover:border-primary group flex cursor-pointer items-center justify-between rounded-xl border border-gray-200 p-3 transition-colors dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <x-icons.paper-clip class="group-hover:text-primary h-5 w-5 text-gray-400" />
                                <span
                                    class="text-sm font-medium text-gray-600 dark:text-gray-400">Surat_Undangan.pdf</span>
                            </div>
                            <x-icons.chevron-right class="h-4 w-4 text-gray-300" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Timeline --}}
        <div class="flex flex-col gap-6">
            <div
                class="rounded-[2rem] border border-gray-200 bg-white/70 p-8 shadow-xl backdrop-blur-2xl dark:border-gray-700 dark:bg-dark-primary/70">
                <h3 class="mb-8 flex items-center gap-2 text-lg font-bold text-gray-900 dark:text-white">
                    <x-icons.clock class="text-primary h-5 w-5" />
                    Timeline Approval
                </h3>

                <div class="relative flex flex-col gap-0">
                    {{-- Vertical Line --}}
                    <div class="absolute bottom-2 left-4 top-2 w-0.5 bg-gray-100 dark:bg-white/10"></div>

                    @php
                        $stages = [
                            ['key' => 'pending_backup', 'label' => 'Persetujuan Backup', 'icon' => 'user'],
                            ['key' => 'pending_spv', 'label' => 'Persetujuan SPV', 'icon' => 'user-group'],
                            ['key' => 'pending_hrd', 'label' => 'Persetujuan HRD', 'icon' => 'check-badge'],
                            ['key' => 'pending_management', 'label' => 'Persetujuan Manajemen', 'icon' => 'building'],
                            ['key' => 'approved', 'label' => 'Selesai', 'icon' => 'check-circle'],
                        ];

                        $currentStageIndex = 0;
                        foreach ($stages as $idx => $s) {
                            if ($s['key'] == $request->status) {
                                $currentStageIndex = $idx;
                            }
                        }
                        if ($request->status == 'approved') {
                            $currentStageIndex = 4;
                        }
                    @endphp

                    @foreach ($stages as $index => $stage)
                        @php
                            $isDone = $index < $currentStageIndex;
                            $isActive = $index === $currentStageIndex;
                            $isPending = $index > $currentStageIndex;
                        @endphp

                        <div class="group relative flex gap-4 pb-8">
                            {{-- Circle Indicator --}}
                            <div class="relative z-10">
                                @if ($isDone)
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 text-white ring-4 ring-green-100 dark:ring-green-900/30">
                                        <x-icons.check class="h-5 w-5" />
                                    </div>
                                @elseif($isActive)
                                    <div
                                        class="bg-primary ring-primary/20 flex h-8 w-8 animate-pulse items-center justify-center rounded-full text-white ring-4">
                                        <div class="h-2 w-2 rounded-full bg-white"></div>
                                    </div>
                                @else
                                    <div
                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 text-gray-400 ring-4 ring-transparent dark:bg-gray-800 dark:text-gray-600">
                                        <div class="h-2 w-2 rounded-full bg-current"></div>
                                    </div>
                                @endif
                            </div>

                            <div class="-mt-0.5 flex flex-col">
                                <h4
                                    class="{{ $isActive ? 'text-primary' : ($isDone ? 'text-gray-900 dark:text-white' : 'text-gray-400') }} text-sm font-bold">
                                    {{ $stage['label'] }}
                                </h4>
                                @if ($isDone)
                                    <p class="mt-0.5 text-xs text-gray-500">Selesai pada
                                        {{ now()->subHours(5 - $index)->format('H:i') }}</p>
                                @elseif($isActive)
                                    <p class="text-primary mt-0.5 text-xs font-medium italic">Sedang dalam proses...</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
