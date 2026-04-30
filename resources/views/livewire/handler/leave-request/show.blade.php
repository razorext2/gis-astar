<div class="mt-4 flex flex-col gap-6">
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
                    wire:confirm="Apakah Anda yakin ingin membatalkan pengajuan cuti ini?">
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
            <x-leave-request.detail-card :request="$request" />
        </div>

        {{-- Right: Timeline --}}
        <div class="flex flex-col gap-6">
            <x-leave-request.timeline :request="$request" />
        </div>
    </div>
</div>
