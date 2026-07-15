{{-- Goal: Pengaturan Cuti tab router, Livewire: Handler.LeaveRequest.ManageBalances.Index, Alpine: true --}}

<div class="flex flex-col gap-4" x-data="{ activeTab: 'balances' }">

    {{-- Header / Tab Switcher --}}
    <div class="flex flex-col gap-4 rounded-xl border border-zinc-200 p-4 dark:border-zinc-800 md:p-6 sm:flex-row sm:items-center sm:justify-between"
    x-bind:class="dynamicBg ? 'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-lg shadow-red-500/10' : 'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-red-500/10 text-red-500">
                <x-icons.user-group class="h-8 w-8" />
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Pengaturan Cuti</h1>
                <div class="mt-1 flex items-center gap-2">
                    <button @click="activeTab = 'balances'"
                        :class="activeTab === 'balances' ? 'text-red-600 bg-red-50 dark:bg-red-900/20' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="rounded-lg px-3 py-1 text-xs font-bold transition-all">
                        Kelola Saldo
                    </button>
                    <button @click="activeTab = 'types'"
                        :class="activeTab === 'types' ? 'text-red-600 bg-red-50 dark:bg-red-900/20' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="rounded-lg px-3 py-1 text-xs font-bold transition-all">
                        Tipe Cuti
                    </button>
                    <button @click="activeTab = 'current'"
                        :class="activeTab === 'current' ? 'text-red-600 bg-red-50 dark:bg-red-900/20' : 'text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="rounded-lg px-3 py-1 text-xs font-bold transition-all">
                        Sedang Cuti
                    </button>
                </div>
            </div>
        </div>
        <div class="flex shrink-0">
            <livewire:handler.leave-request.import-leave-request />
        </div>
    </div>

    {{-- Tab: Kelola Saldo --}}
    <div x-show="activeTab === 'balances'" x-transition>
        <livewire:handler.leave-request.manage-balances.table />
    </div>

    {{-- Tab: Tipe Cuti --}}
    <div x-show="activeTab === 'types'" x-transition>
        <livewire:handler.leave-request.manage-leave-types />
    </div>

    {{-- Tab: Sedang Cuti --}}
    <div x-show="activeTab === 'current'" x-transition>
        <livewire:handler.leave-request.current-leave-list />
    </div>

</div>
