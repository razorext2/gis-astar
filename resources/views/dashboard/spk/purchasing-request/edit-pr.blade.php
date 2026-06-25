@extends('dashboard.layoutsDash.app')
{{-- Goal: Page wrapper for Edit PR, Livewire: handler.spk.edit-purchasing-request, Alpine: - --}}
@section('content')
    <div class="mb-16 space-y-4">

        <div
            class="flex flex-col rounded-xl border border-zinc-200 bg-white/60 p-4 shadow-md backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/60 dark:shadow-none lg:p-6">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <x-button.secondary href="{{ route('purchasing-request.show', $data->id) }}" class="shrink-0"
                        wire:navigate id="back-button">
                        <x-icons.angle-left class="h-5 w-5" />
                    </x-button.secondary>
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Edit Purchasing Request</h1>
                            <span
                                class="inline-flex items-center rounded-md bg-amber-50 px-2 py-0.5 text-xs font-bold text-amber-700 ring-1 ring-inset ring-amber-700/10 dark:bg-amber-900/30 dark:text-amber-400">
                                {{ $data->nomor_order . ($data->revision_count ? 'R' . str_pad($data->revision_count, 2, '0', STR_PAD_LEFT) : '') }}
                            </span>
                        </div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            Edit data PR, tambah PR baru, atau hapus item PR yang sudah di-assign.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Customer Quick Info --}}
            <div
                class="mt-4 flex items-center gap-3 rounded-lg border border-zinc-100 bg-zinc-50/50 p-3 shadow dark:border-zinc-800/50 dark:bg-zinc-800/30">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white shadow-sm dark:bg-zinc-800">
                    <x-icons.office-building class="h-5 w-5 text-zinc-400" />
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Pelanggan / Perusahaan</p>
                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                        {{ $data->customer['nama_perusahaan'] ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        @livewire('handler.spk.edit-purchasing-request', ['id' => $data->id, 'nomorOrder' => $data->nomor_order])

    </div>
@endsection
