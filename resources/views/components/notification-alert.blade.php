<div
	class="{{ $class }} relative mb-6 flex items-center gap-x-2 rounded-xl border-x border-b border-t-4 border-x-gray-200 border-b-gray-200 border-t-red-300 bg-white p-2 text-gray-600 dark:border-x-gray-700 dark:border-b-gray-700 dark:border-t-red-800 dark:bg-[#18181b] dark:text-white md:gap-x-4 md:p-4"
	id="{{ $id }}" role="alert" {{ $attributes }}>

	<div
		class="absolute -top-3.5 left-4 items-center justify-center rounded-lg border-t border-red-300 bg-white px-2 py-1 text-xs font-semibold text-red-700 dark:border-red-800">
		<span class="capitalize" id="announcement-title">{{ $title }}</span>
	</div>

	<div class="flex w-full flex-row items-center gap-x-2 text-sm font-medium md:gap-x-4">
		<div>
			<x-icons.bell class="h-5 w-5" />
		</div>
		<div class="w-full text-wrap capitalize" id="announcement-description">
			{{ $desc }}
		</div>
	</div>

</div>
