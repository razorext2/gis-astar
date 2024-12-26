<div class="relative" x-data="{ open: false }">
	<x-button.primary type="button" @click="open = !open" x-transition="">
		<x-icons.three-dots class="h-4 w-4 rotate-90" />
	</x-button.primary>

	<!-- Dropdown menu -->
	<div class="mt-1 w-auto rounded-lg border border-gray-100 bg-white shadow-md dark:border-none dark:bg-gray-700"
		x-show="open" @click.outside="open = false" x-transition:enter="transition ease-in duration-200"
		x-transition:enter-start="transform opacity-0 -translate-y-5"
		x-transition:enter-end="transform opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
		x-transition:leave-start="transform opacity-100 translate-y-0"
		x-transition:leave-end="transform opacity-0 -translate-y-5">
		<ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
			@if ($show['show'])
				<li>
					<a class="block px-4 py-2 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
						href="{{ $show['url'] }}">Show</a>
				</li>
			@endif

			@if ($edit['show'])
				<li>
					<a class="block px-4 py-2 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600"
						href="{{ $edit['url'] }}">Edit</a>
				</li>
			@endif

			@if ($delete['show'])
				<li>
					<a class="block px-4 py-2 font-medium text-red-500 hover:bg-red-300 hover:text-red-700" id="delete-btn"
						data-id="{{ $id }}" href="javascript:void(0)">Delete</a>
				</li>
			@endif
		</ul>
	</div>
</div>
