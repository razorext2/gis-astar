{{-- Goal: Display a table of the 5 most recent SPKs, Livewire: RecentSpk, Alpine: None --}}
<div>
    @can('spk-list')
        <div
            class="flex h-full flex-col rounded-xl border border-zinc-200 bg-white/60 p-5 shadow-sm backdrop-blur-md dark:border-zinc-800 dark:bg-dark-primary/60 md:p-6">
            <div
                class="mb-4 flex flex-col justify-between gap-3 border-b border-zinc-200 pb-4 dark:border-zinc-800 sm:flex-row sm:items-center">
                <div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Aktivitas SPK Terkini</h3>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">5 Surat Perintah Kerja terbaru.</p>
                </div>
                <a href="{{ route('spk.index') }}"
                    class="inline-flex w-fit items-center text-sm font-semibold text-red-600 transition-colors hover:text-red-700 dark:text-red-500 dark:hover:text-red-400">
                    Lihat Semua
                    <x-icons.angle-right class="ml-1 h-4 w-4" />
                </a>
            </div>

            <div class="custom-scrollbar flex-1 overflow-x-auto">
                <table class="w-full text-left text-sm text-zinc-500 dark:text-zinc-400">
                    <thead class="bg-zinc-50/50 text-xs uppercase text-zinc-700 dark:bg-zinc-800/50 dark:text-zinc-300">
                        <tr>
                            <th scope="col" class="rounded-l-lg px-4 py-3 font-bold">Nomor SPK</th>
                            <th scope="col" class="px-4 py-3 font-bold">Customer</th>
                            <th scope="col" class="px-4 py-3 font-bold">Status</th>
                            <th scope="col" class="rounded-r-lg px-4 py-3 font-bold">Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($recentSpks as $spk)
                            <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-zinc-900 dark:text-white">
                                    {{ $spk->nomor_order ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="max-w-[200px] truncate"
                                        title="{{ is_array($spk->customer) && isset($spk->customer['name']) ? $spk->customer['name'] : $spk->company_name ?? '-' }}">
                                        {{ is_array($spk->customer) && isset($spk->customer['name']) ? $spk->customer['name'] : $spk->company_name ?? '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <span
                                        class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                                        {{ $spk->status_description }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="h-6 w-6 overflow-hidden rounded-full border border-zinc-200 dark:border-zinc-700">
                                            <img src="{{ $spk->addedBy?->profile_pic ? asset('storage/profile-pictures/' . $spk->addedBy->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
                                                alt="{{ $spk->addedBy->name ?? 'User' }}" class="h-full w-full object-cover"
                                                onerror="this.src = '{{ asset('assets/img/noImage.webp') }}'">
                                        </div>
                                        <div class="flex items-center gap-x-2">
                                            <span>{{ $spk->addedBy->name ?? 'System' }}</span>
                                            @if ($spk->addedBy)
                                                <x-dashboard.badge-inactive :is_active="$spk->addedBy->is_active ?? true" />
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-icons.clipboard-list class="mb-2 h-8 w-8 text-zinc-300 dark:text-zinc-600" />
                                        <span>Belum ada SPK yang dibuat.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endcan
</div>
