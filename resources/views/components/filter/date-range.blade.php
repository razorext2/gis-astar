<div class="flex items-center gap-2 md:gap-4" id="date-range-picker" datepicker-format="yyyy-mm-dd" date-rangepicker>
    <div class="relative w-full">
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
            <x-icons.date class="h-4 w-4 text-zinc-500 dark:text-zinc-400" />
        </div>
        <input
            class="block w-full rounded-lg border border-zinc-200 bg-zinc-50 p-2.5 ps-10 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white dark:placeholder-zinc-500 dark:focus:border-blue-500 dark:focus:ring-blue-500"
            id="datepicker-range-start" name="start" type="text" placeholder="Start date">
    </div>
    <div class="relative w-full">
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
            <x-icons.date class="h-4 w-4 text-zinc-500 dark:text-zinc-400" />
        </div>
        <input
            class="block w-full rounded-lg border border-zinc-200 bg-zinc-50 p-2.5 ps-10 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white dark:placeholder-zinc-500 dark:focus:border-blue-500 dark:focus:ring-blue-500"
            id="datepicker-range-end" name="end" type="text" placeholder="End date">
    </div>
</div>
