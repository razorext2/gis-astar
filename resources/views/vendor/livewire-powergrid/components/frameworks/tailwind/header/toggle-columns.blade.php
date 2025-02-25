@if (data_get($setUp, 'header.toggleColumns'))
	<div class="mt-2 sm:mt-0" x-data="{ open: false }" @click.outside="open = false">
		<button
			class="focus:ring-primary-600 focus-within:focus:ring-primary-600 focus-within:ring-primary-600 dark:focus-within:ring-primary-600 flex w-auto rounded-md border-0 bg-transparent bg-white px-3 py-2 text-gray-600 ring-1 ring-gray-300 transition placeholder:text-gray-400 focus-within:ring-2 focus:outline-none dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:placeholder-pg-primary-400 dark:ring-pg-primary-600 sm:text-sm sm:leading-6"
			data-cy="toggle-columns-{{ $tableName }}" @click.prevent="open = ! open">
			<div class="flex">
				<x-livewire-powergrid::icons.eye-off class="h-5 w-5 text-pg-primary-500 dark:text-pg-primary-300" />
			</div>
		</button>

		<div
			class="absolute z-10 mt-2 w-56 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-pg-primary-700"
			tabindex="-1" x-cloak x-show="open" x-transition:enter="transition ease-out duration-100"
			x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
			x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
			x-transition:leave-end="transform opacity-0 scale-95" @keydown.tab="open = false"
			@keydown.enter.prevent="open = false;" @keyup.space.prevent="open = false;">
			<div role="none">
				@foreach ($this->visibleColumns as $column)
					<div data-cy="toggle-field-{{ data_get($column, 'isAction') ? 'actions' : data_get($column, 'field') }}"
						wire:key="toggle-column-{{ data_get($column, 'isAction') ? 'actions' : data_get($column, 'field') }}"
						wire:click="$dispatch('pg:toggleColumn-{{ $tableName }}', { field: '{{ data_get($column, 'field') }}'})"
						@class([
							'font-semibold bg-pg-primary-100 dark:bg-pg-primary-800 ' => data_get(
								$column,
								'hidden'),
							'py-1' => $loop->first || $loop->last,
							'cursor-pointer text-sm flex justify-between block px-4 py-2 text-pg-primary-800 hover:bg-pg-primary-100 hover:text-black-300 dark:text-pg-primary-200 dark:hover:bg-pg-primary-800',
						])>
						<div>
							{!! data_get($column, 'title') !!}
						</div>
						@if (!data_get($column, 'hidden'))
							<x-livewire-powergrid::icons.eye class="h-5 w-5 text-pg-primary-200 dark:text-pg-primary-300" />
						@else
							<x-livewire-powergrid::icons.eye-off class="h-5 w-5 text-pg-primary-500 dark:text-pg-primary-300" />
						@endif
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endif
