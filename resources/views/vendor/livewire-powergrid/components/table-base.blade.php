@props([
    'readyToLoad' => false,
    'items' => null,
    'lazy' => false,
    'tableName' => null,
    'theme' => null,
])
<div @isset($this->setUp['responsive']) x-data="pgResponsive" @endisset>
	<table class="power-grid-table {{ theme_style($theme, 'table.layout.table') }} table"
		id="table_base_{{ $tableName }}">
		<thead class="{{ theme_style($theme, 'table.header.thead') }}">
			{{ $header }}
		</thead>
		@if ($readyToLoad)
			<tbody class="{{ theme_style($theme, 'table.body.tbody') }}">
				{{ $body }}
			</tbody>
		@else
			<tbody class="{{ theme_style($theme, 'table.body.tbody') }}">
				{{ $loading }}
			</tbody>
		@endif
	</table>

	{{-- infinite pagination handler --}}
	@if ($this->canLoadMore && $lazy)
		<div class="items-center justify-center" wire:loading.class="flex" wire:target="loadMore">
			@include(data_get($theme, 'root') . '.header.loading')
		</div>

		<div x-data="pgLoadMore"></div>
	@endif
</div>
