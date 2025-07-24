@props(['capitalize' => true])

<div class="flex w-fit min-w-32 flex-col items-start gap-1 text-wrap">
	<span class="{{ $capitalize ? 'capitalize' : '' }} text-xs text-gray-400">{{ $user->kode_pegawai ?? 'N/A' }}</span>
	<span class="font-medium capitalize dark:text-gray-200">{{ $user->name ?? 'N/A' }}</span>

	@if ($data->status == 5)
		@if (auth()->user()->can('driver-approve') || $data->assign_date <= now())
			<a href="{{ route('driver.assign.update', $data->id) }}"
				class="rounded-md px-3 py-1 text-sm ring-1 ring-blue-700 transition-transform duration-300 ease-in-out will-change-transform hover:scale-105 hover:bg-blue-300 focus:scale-105 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900">
				Update
			</a>
		@endif
	@endif
</div>
