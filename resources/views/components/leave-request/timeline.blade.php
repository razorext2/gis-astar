{{-- Goal: Reusable timeline component for leave request history and status tracking, Deps: LeaveRequest --}}
@props(['request'])

<div
    class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm backdrop-blur-xl dark:border-zinc-800 dark:bg-dark-primary">
    <h3 class="mb-6 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-zinc-400">
        <x-icons.clockwise class="h-4 w-4" />
        Alur Pengajuan
    </h3>

    <div class="relative space-y-6">
        <div class="absolute left-[15px] top-2 h-[calc(100%-16px)] w-0.5 bg-zinc-100 dark:bg-zinc-800">
        </div>

        {{-- Processed History --}}
        @foreach ($request->histories as $history)
            <div class="relative flex gap-4">
                <div @class([
                    'relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2',
                    'border-green-500 bg-green-50 text-green-600 dark:bg-green-900' => !in_array(
                        $history->status_to,
                        ['rejected', 'canceled', 'cancelled']),
                    'border-red-500 bg-red-50 text-red-600 dark:bg-red-900' => in_array(
                        $history->status_to,
                        ['rejected', 'canceled', 'cancelled']),
                ])>
                    @if (in_array($history->status_to, ['rejected', 'canceled', 'cancelled']))
                        <x-icons.close class="h-4 w-4" />
                    @else
                        <x-icons.check class="h-4 w-4" />
                    @endif
                </div>
                <div class="flex flex-col gap-1">
                    <p class="text-sm font-bold text-zinc-900 dark:text-white">{{ $history->description }}
                    </p>
                    <div class="flex items-center gap-2 text-[10px] font-medium text-zinc-500">
                        <span>{{ $history->actedByUser->name ?? '-' }}</span>
                        <span>•</span>
                        <span>{{ $history->created_at->diffForHumans() }}</span>
                    </div>
                    @if ($history->note)
                        <p
                            class="mt-1 rounded-xl bg-zinc-50 px-3 py-1.5 text-xs italic text-zinc-600 dark:bg-white/5 dark:text-zinc-400">
                            "{{ $history->note }}"
                        </p>
                    @endif
                </div>
            </div>
        @endforeach

        {{-- Current Pending Step Indicator --}}
        @if (in_array($request->status, ['pending_backup', 'pending_spv', 'pending_hrd', 'pending_management']))
            @php
                $nextStep = match ($request->status) {
                    'pending_backup' => [
                        'title' => 'Tahap Saat Ini: Validasi Personel Backup',
                        'description' => 'Menunggu konfirmasi dari rekan kerja yang ditunjuk sebagai backup.',
                        'person' => $request->backupPerson->name ?? 'Personel Backup',
                    ],
                    'pending_spv' => [
                        'title' => 'Tahap Saat Ini: Validasi Atasan Langsung',
                        'description' => $request->user->pegawai->jabatanRelasi->supervisor_id
                            ? 'Menunggu persetujuan dari Atasan Langsung.'
                            : 'PERINGATAN: Konfigurasi atasan untuk jabatan ini belum diset.',
                        'person' =>
                            $request->user->pegawai->jabatanRelasi->supervisor->name ?? 'Atasan (Belum Terkonfigurasi)',
                    ],
                    'pending_hrd' => [
                        'title' => 'Tahap Saat Ini: Validasi HRD',
                        'description' => 'Sedang dalam proses peninjauan oleh departemen HRD.',
                        'person' => 'HRD Department',
                    ],
                    'pending_management' => [
                        'title' => 'Tahap Saat Ini: Validasi Management',
                        'description' => 'Menunggu keputusan akhir dari pihak Direksi/Management.',
                        'person' => 'Management / Direksi',
                    ],
                    default => null,
                };
            @endphp

            @if ($nextStep)
                <div class="relative flex gap-4 opacity-70">
                    <div
                        class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2 border-dashed border-zinc-300 bg-white text-zinc-400 dark:border-zinc-700 dark:bg-dark-primary">
                        <x-icons.clock class="h-4 w-4" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="text-xs font-bold italic text-zinc-500 dark:text-zinc-400">
                            {{ $nextStep['title'] }}
                        </p>
                        <div class="flex flex-col text-[10px] font-medium text-zinc-400">
                            <span>Pihak: <span
                                    class="text-zinc-600 dark:text-zinc-300">{{ $nextStep['person'] }}</span></span>
                            <span>{{ $nextStep['description'] }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
