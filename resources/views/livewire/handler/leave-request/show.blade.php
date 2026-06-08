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
        <x-leave-request.deadline-timer :updatedAt="$request->updated_at" />
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
