<!-- start DeleteModal -->
<div class="fixed z-[100] hidden h-full w-full overflow-y-auto overflow-x-hidden bg-gray-800/50 p-4 md:inset-0"
    id="deleteModal" data-modal-placement="center-center" tabindex="-1">
    <div class="relative top-1/3 mx-auto max-h-full w-full max-w-md">
        <div class="relative rounded-lg bg-white shadow ring-1 ring-zinc-200 dark:bg-gray-700 dark:ring-zinc-800">
            <!-- Modal Header -->
            <div class="flex items-start justify-between rounded-t border-b p-4 dark:border-zinc-800">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Confirm Delete
                </h3>
                <button
                    class="ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="deleteModal" type="button">
                    <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Are you sure you want to delete this data? This action cannot be undone.
                </p>
            </div>
            <!-- Modal Footer -->
            <div class="flex items-center space-x-2 rounded-b border-t border-zinc-200 p-6 dark:border-zinc-800">
                <!-- Delete Confirmation Form -->
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-800 dark:hover:bg-red-900 dark:focus:ring-red-900"
                        type="submit">
                        Yes, Delete
                    </button>
                </form>
                <button
                    class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:border-zinc-800 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-zinc-800"
                    data-modal-hide="deleteModal" type="button">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end DeleteModal -->
