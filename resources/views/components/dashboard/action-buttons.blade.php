@props(['delete' => false, 'detail' => false])

<div class="inline-flex max-w-10" x-data="{ open: false }">
	<x-button.primary class="h-9 w-9" type="button" @click="open = !open" x-transition="">
		<x-icons.three-dots class="h-4 w-4 rotate-90" />
	</x-button.primary>

	<!-- Dropdown menu -->
	<div class="relative" x-show="open" @click.outside="open = false" x-transition:enter="transition ease-in duration-200"
		x-transition:enter-start="transform opacity-0 -translate-x-2"
		x-transition:enter-end="transform opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="transform opacity-100 translate-x-0"
		x-transition:leave-end="transform opacity-0 -translate-x-2">
		<ul
			class="absolute -top-10 left-2 flex w-auto flex-col rounded-lg bg-white text-sm text-gray-700 shadow-md ring-1 ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:ring-0 md:flex-row">
			@foreach ($datas as $item)
				<li>
					<a
						class="{{ $item['id'] == 'delete-btn' ? 'text-red-500 hover:bg-red-500 hover:text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-white' }} block rounded-md px-4 py-2.5 transition-colors duration-300 ease-in-out"
						id="{{ $item['id'] }}" data-id="{{ $id }}" href="{{ $item['action'] }}"
						data-userid="{{ Crypt::encryptString(auth()->user()->id) }}">
						{{ $item['label'] }}
					</a>
				</li>
			@endforeach

			@if ($detail)
				<li>
					<button
						class="block rounded-md px-4 py-2.5 transition-colors duration-300 ease-in-out hover:bg-gray-100 hover:text-white dark:text-white dark:hover:bg-gray-600"
						id="detail-btn" wire:click="$dispatch('detail', {id: {{ $id }}})"
						data-userid="{{ Crypt::encryptString(auth()->user()->id) }}">
						Confirm
					</button>
				</li>
			@endif

			@if ($delete)
				<li>
					<button
						class="block rounded-md px-4 py-2.5 text-red-500 transition-colors duration-300 ease-in-out hover:bg-red-500 hover:text-white"
						id="delete-btn" wire:click="$dispatch('delete', {id: {{ $id }}})">
						Hapus
					</button>
				</li>
			@endif
		</ul>
	</div>
</div>
