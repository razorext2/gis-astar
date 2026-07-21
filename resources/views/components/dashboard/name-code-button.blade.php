{{-- Goal: Render employee name, code, button and optional inactive badge, Livewire: -, Alpine: - --}}
@props(['capitalize' => true])

<div class="flex w-fit min-w-32 flex-col items-start gap-1 text-wrap">
    <span class="{{ $capitalize ? 'capitalize' : '' }} text-xs text-zinc-400">{{ $user->kode_pegawai ?? 'Belum Diatur' }}</span>
    <span class="font-medium capitalize dark:text-zinc-200 inline-flex items-center gap-1.5">
        {{ $user->name ?? 'Belum Diatur' }}
        @if (isset($user))
            <x-dashboard.badge-inactive :is_active="$user->is_active ?? true" />
        @endif
    </span>


    @if ($data->status == 5)
        @if (auth()->user()->can('driver-approve') || $data->assign_date <= now())
            <a href="{{ Route::has('driver.assign.update') ? route('driver.assign.update', $data->id) : '#' }}"
                class="rounded-md px-3 py-1 text-sm ring-1 ring-blue-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-blue-300 focus:scale-105 dark:bg-blue-800 dark:text-white dark:ring-zinc-800 dark:hover:bg-blue-900">
                Update
            </a>
        @endif
    @endif
</div>
