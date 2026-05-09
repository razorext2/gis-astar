<div>
    <form class="mt-4" wire:submit.prevent="save">
        <div class="mb-4 grid gap-6 sm:mb-5 sm:gap-6">
            <div class="w-full">
                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="role_name">
                    Nama Role
                </label>
                <x-input.basic name="role_name" id="role_name" placeholder="Isi dengan nama role" wire:model="form.name"
                    required />
                @error('form.name')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Permissions</label>

                <div class="mb-2">
                    <x-input.basic name="searchPermission" id="searchPermission" placeholder="Cari perizinan"
                        wire:model.live="searchPermission" />
                </div>

                <input
                    class="h-4 w-4 rounded border-zinc-200 bg-gray-100 text-green-600 focus:ring-2 focus:ring-green-500 dark:border-zinc-800 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-green-600"
                    id="select-all" type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll">
                <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300" id="select-all-label"
                    for="select-all">
                    Select All
                </label>

                <div class="mt-4 space-y-4">
                    @foreach ($groupedPermissions as $group => $perms)
                        <div
                            class="rounded-xl border border-zinc-200 bg-white/50 p-4 backdrop-blur-sm dark:border-zinc-800 dark:bg-gray-800/50">
                            <h3
                                class="mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400">
                                <span class="h-1 w-4 rounded-full bg-blue-600 dark:bg-blue-400"></span>
                                {{ $group }}
                            </h3>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                                @foreach ($perms as $permission)
                                    <div
                                        class="group flex items-center space-x-2 transition-all duration-200 hover:translate-x-1">
                                        <input
                                            class="permission-checkbox h-4 w-4 rounded border-zinc-200 bg-gray-100 text-green-600 focus:ring-2 focus:ring-green-500 dark:border-zinc-800 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-green-600"
                                            id="permission[{{ $permission->id }}]"
                                            name="permission[{{ $permission->id }}]" type="checkbox"
                                            value="{{ $permission->id }}" wire:model="form.selectedPermissions">
                                        <label
                                            class="cursor-pointer text-sm font-medium text-gray-700 transition-colors group-hover:text-green-600 dark:text-gray-300 dark:group-hover:text-green-400"
                                            for="permission[{{ $permission->id }}]">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('form.selectedPermissions')
                    <span class="error mt-2 text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex items-center">
            <x-button.primary id="store" type="submit" wire:loading.attr="disabled" wire:target="save">
                <x-slot name="icon">
                    <x-icons.angle-right wire:loading.remove wire:target="save" class="icon h-5 w-5" />
                    <x-icons.loading wire:loading wire:target="save" class="h-4 w-4 animate-spin" />
                </x-slot>

                <span wire:loading.remove wire:target="save">Simpan</span>
                <span wire:loading wire:target="save">Memproses...</span>
            </x-button.primary>
        </div>
    </form>
</div>
