<div class="w-full">

    <h3 class="mb-2 text-base font-semibold text-gray-800 dark:text-white lg:mb-4">
        Daftar staff pada project ini
    </h3>

    <div class="w-full rounded-xl bg-white/60 shadow-sm border border-zinc-200 backdrop-blur-md dark:bg-gray-800 dark:border-zinc-800">

        <div class="divide-y divide-gray-200 dark:divide-gray-700">

            @forelse ($this->assignments as $index => $row)
                <div class="relative p-2 transition hover:bg-gray-50 dark:hover:bg-gray-700/40 lg:p-4">

                    <span
                        class="absolute right-0 top-0 flex h-6 w-6 items-center justify-center rounded bg-green-500 text-xs font-semibold text-white">
                        {{ $index + 1 }}
                    </span>

                    <div class="mb-2 w-full lg:mb-4">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ ucwords($row->project->project_name) }}
                        </h4>

                        <p class="text-base font-medium text-gray-600 dark:text-gray-200">
                            [{{ $row->project->spk->customer['nama_perusahaan'] }}]
                        </p>
                    </div>

                    {{-- HEADER --}}
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                        {{-- TIME --}}
                        <div class="text-sm text-gray-600 dark:text-gray-300">
                            <p class="font-medium">
                                Pukul {{ \Carbon\Carbon::parse($row->assign_at)->isoFormat('HH:mm:ss') }}
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($row->assign_at)->isoFormat('dddd, DD MMM YYYY') }}
                            </p>
                        </div>

                        {{-- DATA --}}
                        <div class="w-full lg:max-w-xl">
                            <dl class="grid grid-cols-1 gap-2 text-sm sm:grid-cols-2">
                                <div class="flex justify-between sm:block">
                                    <dt class="text-gray-500 dark:text-gray-400">
                                        Tipe Laporan
                                    </dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">
                                        {{ ucfirst($row->laporan_type) }}
                                    </dd>
                                </div>

                                <div class="flex justify-between sm:block">
                                    <dt class="text-gray-500 dark:text-gray-400">
                                        Nomor VT
                                    </dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">
                                        {{ $row->nomor_vt }}
                                    </dd>
                                </div>

                                <div class="flex justify-between sm:block">
                                    <dt class="text-gray-500 dark:text-gray-400">
                                        Nama Staf
                                    </dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">
                                        [{{ $row->assignTo->kode_pegawai }}]
                                        {{ $row->assignTo->name }}
                                    </dd>
                                </div>

                                <div class="flex justify-between sm:block">
                                    <dt class="text-gray-500 dark:text-gray-400">
                                        Deadline
                                    </dt>
                                    <dd class="font-medium text-gray-900 dark:text-white">
                                        {{ $row->project->start_date }} s/d
                                        {{ $row->project->end_date }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="mt-2 flex items-center justify-between lg:mt-4">
                        {{-- STATUS --}}
                        <span
                            class="inline-flex items-center rounded-md bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-200">
                            {{ ucfirst($row->status) }}
                        </span>

                        {{-- ACTION --}}
                        <div class="flex items-center gap-2 text-sm">

                            <x-button.link
                                class="ring-blue-600 hover:bg-blue-100 dark:bg-blue-800 dark:text-white dark:hover:bg-blue-900"
                                id="detail-button" href="{{ route('daily-report.daily', ['id' => $row->id]) }}">
                                Detail
                            </x-button.link>

                            @can('unassign-laporan-harian-spk')
                                <x-button.danger id="unassign-button" wire:click="unassign('{{ $row->id }}')"
                                    wire:confirm.prompt="Anda yakin ingin menghapus staf ini dari projek?\nKetik YA jika ingin menghapus|YA">
                                    Unassign
                                </x-button.danger>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-gray-500 dark:text-gray-400">
                    Belum ada staf yang diassign.
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-zinc-200 p-2 dark:border-zinc-800 lg:p-4">
            {{ $this->assignments->links() }}
        </div>
    </div>
</div>
