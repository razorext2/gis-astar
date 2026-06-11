{{-- Goal: Powergrid table pagination, Livewire: N/A, Alpine: N/A --}}
<div class="items-center justify-between gap-2 sm:flex" wire:loading.class="blur-[2px]" wire:target="loadMore">
	<div class="w-full items-center justify-between sm:flex sm:flex-1">
		@if ($recordCount === 'full')
			<div @class(['mr-3' => $paginator->hasPages()])>
				<div @class([
					'mr-2' => $paginator->hasPages(),
					'leading-5 text-center text-pg-primary-700 text-md dark:text-pg-primary-300 sm:text-right',
				])>
					{{ trans('livewire-powergrid::datatable.pagination.showing') }}
					<span class="firstItem font-semibold">{{ $paginator->firstItem() }}</span>
					{{ trans('livewire-powergrid::datatable.pagination.to') }}
					<span class="lastItem font-semibold">{{ $paginator->lastItem() }}</span>
					{{ trans('livewire-powergrid::datatable.pagination.of') }}
					<span class="total font-semibold">{{ $paginator->total() }}</span>
					{{ trans('livewire-powergrid::datatable.pagination.results') }}
				</div>
			</div>
		@elseif($recordCount === 'short')
			<div @class(['mr-3' => $paginator->hasPages()])>
				<p @class([
					'mr-2' => $paginator->hasPages(),
					'leading-5 text-center text-pg-primary-700 text-md dark:text-pg-primary-300 sm:text-right',
				])>
					<span class="firstItem font-semibold"> {{ $paginator->firstItem() }}</span>
					-
					<span class="lastItem font-semibold"> {{ $paginator->lastItem() }}</span>
					|
					<span class="total font-semibold"> {{ $paginator->total() }}</span>
				</p>
			</div>
		@elseif($recordCount === 'min')
			<div @class(['mr-3' => $paginator->hasPages()])>
				<p @class([
					'mr-2' => $paginator->hasPages(),
					'leading-5 text-center text-pg-primary-700 text-md dark:text-pg-primary-300 sm:text-right',
				])>
					<span class="firstItem font-semibold"> {{ $paginator->firstItem() }}</span>
					-
					<span class="lastItem font-semibold"> {{ $paginator->lastItem() }}</span>
				</p>
			</div>
		@endif

		@if ($paginator->hasPages() && !in_array($recordCount, ['min', 'short']))
			<nav role="navigation" aria-label="Pagination Navigation" class="items-center justify-between sm:flex">
				<div class="mt-2 flex justify-center sm:mt-0 md:flex-none md:justify-end">

					@if (!$paginator->onFirstPage())
						<a
							class="focus:shadow-outline-blue relative inline-flex cursor-pointer items-center rounded-l-md border border-pg-primary-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-pg-primary-500 transition duration-150 ease-in-out hover:text-pg-primary-400 focus:z-10 focus:outline-none active:bg-pg-primary-100 active:text-pg-primary-500 dark:border-transparent dark:bg-pg-primary-600 dark:text-pg-primary-300"
							wire:click="gotoPage(1, '{{ $paginator->getPageName() }}')">
							<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
							</svg>
						</a>

						<a
							class="focus:shadow-outline-blue relative inline-flex cursor-pointer items-center border border-pg-primary-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-pg-primary-500 transition duration-150 ease-in-out hover:text-pg-primary-400 focus:z-10 focus:outline-none active:bg-pg-primary-100 active:text-pg-primary-500 dark:border-transparent dark:bg-pg-primary-600 dark:text-pg-primary-300"
							wire:click="previousPage('{{ $paginator->getPageName() }}')" rel="next">
							<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
							</svg>

						</a>
					@endif

					@foreach ($elements as $element)
						@if (is_array($element))
							@foreach ($element as $page => $url)
								@if ($page == $paginator->currentPage())
									<span
										class="text-primary-700 bg-primary-100 border-primary-300 relative z-10 -ml-px inline-flex cursor-default select-none select-none items-center border px-3 py-2 text-sm font-bold dark:border-transparent dark:bg-pg-primary-700 dark:text-pg-primary-300">{{ $page }}</span>
								@elseif (
									$page === $paginator->currentPage() + 1 ||
										$page === $paginator->currentPage() + 2 ||
										$page === $paginator->currentPage() - 1 ||
										$page === $paginator->currentPage() - 2)
									<a
										class="focus:shadow-outline-blue relative -ml-px inline-flex cursor-pointer select-none items-center border border-pg-primary-300 bg-white px-3 py-2 text-sm font-medium leading-5 text-pg-primary-600 transition duration-150 ease-in-out hover:text-pg-primary-500 focus:z-10 focus:outline-none active:bg-pg-primary-100 active:text-pg-primary-700 dark:border-transparent dark:bg-pg-primary-600 dark:text-pg-primary-400"
										wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">{{ $page }}</a>
								@endif
							@endforeach
						@endif
					@endforeach

					@if ($paginator->hasMorePages())
						<a @class([
							'block' => $paginator->lastPage() - $paginator->currentPage() >= 2,
							'hidden' => $paginator->lastPage() - $paginator->currentPage() < 2,
							'select-none cursor-pointer relative inline-flex items-center px-2 py-2 text-sm font-medium text-pg-primary-500 dark:text-pg-primary-300 bg-white dark:bg-pg-primary-600 border border-pg-primary-300 dark:border-transparent leading-5 hover:text-pg-primary-400 focus:z-10 focus:outline-none focus:shadow-outline-blue active:bg-pg-primary-100 active:text-pg-primary-500 transition ease-in-out duration-150',
						]) wire:click="nextPage('{{ $paginator->getPageName() }}')" rel="next">
							<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
							</svg>
						</a>
						<a
							class="focus:shadow-outline-blue relative inline-flex cursor-pointer cursor-pointer select-none items-center rounded-r-md border border-pg-primary-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-pg-primary-500 transition duration-150 ease-in-out hover:text-pg-primary-400 focus:z-10 focus:outline-none active:bg-pg-primary-100 active:text-pg-primary-500 dark:border-transparent dark:bg-pg-primary-600 dark:text-pg-primary-300"
							wire:click="gotoPage({{ $paginator->lastPage() }}, '{{ $paginator->getPageName() }}')">
							<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
							</svg>
						</a>
					@endif
				</div>
			</nav>
		@endif

		<div>
			@if ($paginator->hasPages() && in_array($recordCount, ['min', 'short']))
				<nav role="navigation" aria-label="Pagination Navigation" class="items-center justify-between sm:flex">
					<div class="flex justify-center gap-2 sm:mt-0 md:flex-none md:justify-end">
						<span>
							{{-- Previous Page Link Disabled --}}
							@if ($paginator->onFirstPage())
								<button disabled
									class="focus:shadow-outline text-md group inline-flex items-center justify-center gap-x-2 rounded-md border bg-pg-primary-50 px-4 py-2 font-semibold text-pg-primary-500 outline-none ring-0 ring-inset ring-pg-primary-300 transition-all duration-200 ease-in-out hover:bg-pg-primary-100 hover:shadow-md focus:border-transparent focus:ring-2 focus:ring-offset-white focus-visible:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-80 dark:border-pg-primary-600 dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:shadow-none dark:ring-pg-primary-600 dark:hover:bg-pg-primary-900">
									@lang('Previous')
								</button>
							@else
								@if (is_object($paginator) && method_exists($paginator, 'getCursorName'))
									<button
										wire:click="setPage('{{ $paginator->previousCursor()->encode() }}','{{ $paginator->getCursorName() }}')"
										wire:loading.attr="disabled"
										class="border-1 m-1 cursor-pointer select-none rounded border-pg-primary-400 bg-pg-primary-600 p-2 text-center text-white hover:border-pg-primary-800 hover:bg-pg-primary-600 dark:text-pg-primary-300">
										<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
											<path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
										</svg>

									</button>
								@else
									<button wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
										class="focus:shadow-outline text-md group inline-flex select-none items-center justify-center gap-x-2 rounded-md border bg-pg-primary-50 px-4 py-2 font-semibold text-pg-primary-500 outline-none ring-0 ring-inset ring-pg-primary-300 transition-all duration-200 ease-in-out hover:bg-pg-primary-100 hover:shadow-md focus:border-transparent focus:ring-2 focus:ring-offset-white focus-visible:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-80 dark:border-pg-primary-600 dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:shadow-none dark:ring-pg-primary-600 dark:hover:bg-pg-primary-900">
										@lang('Previous')
									</button>
								@endif
							@endif
						</span>

						<span>
							{{-- Next Page Link --}}
							@if ($paginator->hasMorePages())
								@if (is_object($paginator) && method_exists($paginator, 'getCursorName'))
									<button wire:click="setPage('{{ $paginator->nextCursor()->encode() }}','{{ $paginator->getCursorName() }}')"
										wire:loading.attr="disabled"
										class="border-1 m-1 cursor-pointer select-none rounded border-pg-primary-400 bg-pg-primary-600 p-2 text-center text-white hover:border-pg-primary-800 hover:bg-pg-primary-600 dark:text-pg-primary-300">
										<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
											<path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
										</svg>

									</button>
								@else
									<button wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
										class="focus:shadow-outline text-md group inline-flex select-none items-center justify-center gap-x-2 rounded-md border bg-pg-primary-50 px-4 py-2 font-semibold text-pg-primary-500 outline-none ring-0 ring-inset ring-pg-primary-300 transition-all duration-200 ease-in-out hover:bg-pg-primary-100 hover:shadow-md focus:border-transparent focus:ring-2 focus:ring-offset-white focus-visible:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-80 dark:border-pg-primary-600 dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:shadow-none dark:ring-pg-primary-600 dark:hover:bg-pg-primary-900">
										@lang('Next')
									</button>
								@endif
							@else
								<button disabled
									class="focus:shadow-outline text-md group inline-flex items-center justify-center gap-x-2 rounded-md border bg-pg-primary-50 px-4 py-2 font-semibold text-pg-primary-500 outline-none ring-0 ring-inset ring-pg-primary-300 transition-all duration-200 ease-in-out hover:bg-pg-primary-100 hover:shadow-md focus:border-transparent focus:ring-2 focus:ring-offset-white focus-visible:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-80 dark:border-pg-primary-600 dark:bg-pg-primary-800 dark:text-pg-primary-300 dark:shadow-none dark:ring-pg-primary-600 dark:hover:bg-pg-primary-900">
									@lang('Next')
								</button>
							@endif
						</span>
					</div>
				</nav>
			@endif
		</div>
	</div>
</div>
