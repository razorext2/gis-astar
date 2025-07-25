<div
	class="flex flex-col rounded-xl bg-white p-4 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 sm:p-6">
	<span class="text-sm text-gray-900 dark:text-white lg:text-base">{{ $greet }}</span>
	<span class="font-gaming text-xl text-gray-900 dark:text-white lg:text-2xl">{{ auth()->user()->name }}</span>
	<span class="text-sm italic text-gray-900 dark:text-white lg:text-base">"{{ $pesan }}"</span>
</div>
