<div class="w-full md:flex md:flex-row">
	<div x-data="pgRenderActions">
		<span class="pg-actions" x-html="toHtml"></span>
	</div>
	<div class="flex flex-row items-center justify-center text-sm">
		@if (count($exportOptions) > 0)
			<div class="mt-2 sm:mt-0">
				@include(data_get($theme, 'root') . '.export')
			</div>
		@endif
		@includeIf(data_get($theme, 'root') . '.toggle-columns')
	</div>

	<!-- LOADING -->
	@include(data_get($theme, 'root') . '.loading')
</div>
