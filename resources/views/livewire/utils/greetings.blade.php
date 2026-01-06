<div
    class="flex flex-col rounded-xl bg-red-600 p-4 shadow-md ring-1 ring-gray-200 dark:bg-red-700 dark:shadow-none dark:ring-gray-700 sm:p-6">
    <span class="text-sm font-bold text-white lg:text-base">{{ $greet }}</span>
    <span class="font-gaming text-xl text-white lg:text-2xl">{{ auth()->user()->name }}</span>
    <span class="text-sm italic text-red-200 lg:text-base">"{{ $pesan }}"</span>
</div>
