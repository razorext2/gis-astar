<nav class="flex" aria-label="Breadcrumb">
	<ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
		@foreach ($crumbs as $i => $crumb)
			@if ($i < count($crumbs))
				<li>
					<div class="flex items-center">

						@if ($i > 0)
							<x-icons.angle-right class="h-4 w-4 text-gray-400" />
						@else
							<x-icons.home class="h-4 w-4 text-gray-400" />
						@endif
						<a href="{{ $crumb['url'] }}"
							class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white md:ms-2">{{ $crumb['title'] }}</a>
					</div>
				</li>
			@endif
		@endforeach

	</ol>
</nav>
