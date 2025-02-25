@if (count($enabledFilters))
	<div class="pg-enabled-filters-base mb-2 flex flex-row gap-2" data-cy="enabled-filters">
		@if (count($enabledFilters) > 1)
			<div class="group flex cursor-pointer items-center gap-3">
				<span
					class="inline-flex select-none items-center rounded-md border border-pg-primary-500 bg-pg-primary-100 px-2 py-0.5 text-xs font-bold text-pg-primary-600 outline-none hover:text-pg-primary-500 dark:border-pg-primary-500 dark:bg-pg-primary-900 dark:text-pg-primary-300 dark:hover:text-pg-primary-400"
					wire:click.prevent="clearAllFilters">
					{{ trans('livewire-powergrid::datatable.buttons.clear_all_filters') }}
					<x-livewire-powergrid::icons.x class="ml-1 h-4 w-4" />
				</span>
			</div>
		@endif

		@foreach ($enabledFilters as $filter)
			@isset($filter['label'])
				<div class="group flex cursor-pointer items-center gap-3" wire:key="enabled-filters-{{ $filter['field'] }}">
					<span
						class="inline-flex select-none items-center rounded-md border border-pg-primary-300 bg-white px-2 py-0.5 text-xs font-bold text-pg-primary-600 outline-none hover:text-pg-primary-500 dark:border-pg-primary-600 dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:hover:text-pg-primary-400"
						data-cy="enabled-filters-clear-{{ $filter['field'] }}" wire:click.prevent="clearFilter('{{ $filter['field'] }}')">
						{{ $filter['label'] }}
						<x-livewire-powergrid::icons.x class="ml-1 h-4 w-4" />
					</span>
				</div>
			@endisset
		@endforeach
	</div>
@endif
