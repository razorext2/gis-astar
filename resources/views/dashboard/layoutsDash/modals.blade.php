<!-- start DeleteModal -->
<div class="fixed z-[100] hidden h-full w-full overflow-y-auto overflow-x-hidden bg-zinc-950/65 p-4 backdrop-blur-sm md:inset-0"
    id="deleteModal" data-modal-placement="center-center" tabindex="-1">
    <div class="relative top-1/3 mx-auto max-h-full w-full max-w-md">
        <div class="relative rounded-xl bg-white shadow border border-zinc-200 dark:bg-dark-primary dark:border-zinc-800">
            <!-- Modal Header -->
            <div class="flex items-start justify-between rounded-t border-b p-4 dark:border-zinc-800">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Confirm Delete
                </h3>
                <x-button.secondary class="ml-auto !bg-transparent !p-1.5 !shadow-none ring-0"
                    data-modal-hide="deleteModal" type="button">
                    <x-icons.close class="h-5 w-5" />
                    <span class="sr-only">Close modal</span>
                </x-button.secondary>
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
                    <x-button.danger type="submit">
                        {{ __('Yes, Delete') }}
                    </x-button.danger>
                </form>
                <x-button.secondary data-modal-hide="deleteModal" type="button">
                    {{ __('Cancel') }}
                </x-button.secondary>
            </div>
        </div>
    </div>
</div>
<!-- end DeleteModal -->
