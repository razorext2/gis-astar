@extends('dashboard.pegawai.detail')
@section('menus')
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3 lg:gap-4">
        <!-- Left Column: Personal Info -->
        <div class="space-y-2 lg:col-span-1 lg:space-y-4">
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-6 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60 lg:p-8">
                <!-- Decoration -->
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-blue-500/5 blur-3xl transition-colors group-hover:bg-blue-500/10">
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-1 rounded-full bg-blue-600"></div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Informasi Personal</h3>
                    </div>
                    @if (auth()->user()->can('pegawai-edit'))
                        <x-button.primary class="!p-2" href="{{ route('pegawai.edit', $pegawai->id) }}">
                            <x-slot name="icon">
                                <x-icons.file-pen class="h-4 w-4" />
                            </x-slot>
                        </x-button.primary>
                    @endif
                </div>

                <div class="space-y-6">
                    <!-- Images -->
                    <div class="grid grid-cols-2 gap-2 lg:gap-3">
                        @foreach ($images as $image)
                            @if (!is_null($image))
                                <div class="overflow-hidden rounded-2xl border border-white/20 shadow-inner">
                                    <img onerror="this.onerror=null; this.src='{{ asset('assets/img/noImage.webp') }}';"
                                        class="h-40 w-full object-cover transition-transform duration-500 hover:scale-110"
                                        src="{{ asset('storage/' . $pegawai->storage . $image) }}" alt=""
                                        loading="lazy">
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 gap-2">
                        @php
                            $infoData = [
                                ['label' => 'Kode Pegawai', 'value' => $pegawai->kode_pegawai, 'full' => true],
                                ['label' => 'Nama Lengkap', 'value' => $pegawai->full_name, 'full' => true],
                                ['label' => 'Panggilan', 'value' => $pegawai->nick_name],
                                ['label' => 'No Telepon', 'value' => $pegawai->no_telp],
                                ['label' => 'Tanggal Lahir', 'value' => $pegawai->tgl_lahir],
                                ['label' => 'Jabatan', 'value' => $pegawai->jabatanRelasi->nama_jabatan ?? 'N/A'],
                                ['label' => 'Alamat', 'value' => $pegawai->alamat, 'full' => true],
                            ];
                        @endphp

                        @foreach ($infoData as $item)
                            <div
                                class="{{ $item['full'] ?? false ? 'col-span-full' : '' }} rounded-2xl border border-white/20 bg-white/40 p-3 shadow-sm transition-all hover:bg-white/60 dark:border-zinc-800 dark:bg-white/5 dark:hover:bg-white/10">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                                    {{ $item['label'] }}</p>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $item['value'] ?? 'N/A' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Calendar & Stats -->
        <div class="space-y-2 lg:col-span-2 lg:space-y-4">
            <div
                class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-6 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60 lg:p-8">
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-green-500/5 blur-3xl transition-colors group-hover:bg-green-500/10">
                </div>

                <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-1 rounded-full bg-green-600"></div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                                <span class="text-xs font-normal text-gray-500 dark:text-gray-400">Periode: </span>
                                {{ Request::query('period') ? \Carbon\Carbon::parse(Request::query('period'))->locale('id')->isoFormat('MMMM YYYY') : \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Ringkasan kehadiran harian pegawai.</p>
                        </div>
                    </div>

                    <x-button.primary class="group !rounded-2xl !px-6" id="getAttendancePeriod">
                        <x-slot name="icon">
                            <x-icons.date class="h-4 w-4 transition-transform group-hover:scale-110" />
                        </x-slot>
                        <span>Pilih Periode</span>
                    </x-button.primary>
                </div>

                <div class="grid grid-cols-7 gap-1 md:gap-2">
                    @php
                        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                    @endphp
                    @foreach ($days as $day)
                        <div class="py-2 text-center text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            {{ $day }}
                        </div>
                    @endforeach

                    @foreach ($dd as $date)
                        @if ($date)
                            @php
                                $hasData = $attendanceData->contains(function ($attendance) use ($date) {
                                    return \Carbon\Carbon::parse($attendance->jam_masuk)->isSameDay($date);
                                });
                            @endphp
                            <div class="aspect-square p-0.5 sm:p-1">
                                @if ($hasData)
                                    <x-button.success
                                        class="!h-full !w-full !border-green-400 !bg-gradient-to-br !from-green-500 !to-emerald-600 !p-0 !text-xs !shadow-lg !shadow-green-500/20"
                                        type="button" data-date="{{ $date }}"
                                        data-popover-target="popover-click-{{ $date }}"
                                        data-popover-trigger="click">
                                        {{ \Carbon\Carbon::parse($date)->isoFormat('D') }}
                                    </x-button.success>
                                @else
                                    <x-button.secondary
                                        class="!h-full !w-full !border-zinc-200 !bg-white/50 !p-0 !text-xs !text-gray-400 hover:!border-blue-200 hover:!bg-white hover:!text-blue-600 dark:!border-zinc-800 dark:!bg-white/5 dark:!text-gray-500 dark:hover:!bg-white/10"
                                        type="button" data-date="{{ $date }}"
                                        data-popover-target="popover-click-{{ $date }}"
                                        data-popover-trigger="click">
                                        {{ \Carbon\Carbon::parse($date)->isoFormat('D') }}
                                    </x-button.secondary>
                                @endif
                            </div>
                        @else
                            <div class="aspect-square"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Popovers (Rendered outside overflow-hidden) --}}
            @foreach ($dd as $date)
                @if ($date)
                    <livewire:components.pegawai.attendance-calendar-popover :date="$date" :pegawaiId="$pegawai->id"
                        :kodePegawai="$pegawai->kode_pegawai" :key="'popover-' . $date" />
                @endif
            @endforeach
        </div>
    </div>
@endsection
@push('script')
    <script>
        const libs = "{{ sha1('libs') }}";
        const id = "{{ $pegawai->kode_pegawai }}";
        const ids = "{{ $pegawai->id }}";
    </script>
    @vite('resources/js/pages/pegawai/personalInfo.js')
@endpush
