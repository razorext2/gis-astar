<section>
    <button
        class="block w-full bg-yellow-100 px-4 py-2 text-left text-sm text-yellow-600 transition-all duration-300 ease-in-out hover:bg-yellow-200 dark:bg-yellow-300 dark:text-yellow-700 dark:hover:bg-yellow-400"
        type="button" wire:click="$set('showLogUpdateModal', true)">
        Update Log
    </button>

    @teleport('body')
        {{-- modal tambah laporan Fondasi --}}
        <div id="log-modal" wire:show="showLogUpdateModal" wire:transition.duration.300ms
            class="fixed inset-0 z-[99] flex items-center justify-center bg-black bg-opacity-70 py-8"
            wire:click="$set('showLogUpdateModal', false)">
            @if ($showLogUpdateModal)
                <div class="relative mx-4 my-6 flex w-full flex-col gap-1 overflow-y-auto rounded-xl bg-white p-4 shadow-2xl dark:bg-dark-primary md:w-2/3 md:gap-2 lg:w-1/2 lg:p-6 xl:w-2/5"
                    style="max-height: calc(100vh - 6rem);">

                    <x-button.danger class="absolute right-2 top-2 w-fit" wire:click="$set('showLogUpdateModal', false)">
                        <x-icons.close class="h-4 w-4 text-white" />
                    </x-button.danger>

                    <h2 class="mb-4 text-center text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
                        Log Update
                    </h2>

                    <p class="text-sm text-gray-600 dark:text-gray-100">10 Commit Terakhir</p>

                    <div class="relative border-l border-gray-300 pl-6 dark:border-gray-600">
                        @foreach ($this->logHistories() as $row)
                            @php
                                $commit = $row['commit'];
                                $message = $commit['message'] ?? '-';
                                $name = $commit['committer']['name'] ?? '-';
                                $email = $commit['committer']['email'] ?? '-';
                                $date = \Carbon\Carbon::parse($commit['committer']['date'])->format('d M Y H:i');
                            @endphp

                            <div class="relative mb-4">

                                {{-- Dot Indicator --}}
                                <span
                                    class="absolute -left-[9px] top-2 h-4 w-4 rounded-full border-2 border-white bg-blue-500 dark:border-dark-primary">
                                </span>

                                {{-- Card --}}
                                <div
                                    class="rounded-lg bg-gray-50 p-4 shadow-sm transition hover:shadow-md dark:bg-gray-800">

                                    {{-- Commit Message --}}
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white lg:text-base">
                                        {{ $message }}
                                    </h3>

                                    {{-- Meta Info --}}
                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">
                                            {{ $name }}
                                        </span>
                                        <span class="mx-1">•</span>
                                        <span>{{ $email }}</span>
                                        <span class="mx-1">•</span>
                                        <span>{{ $date }}</span>
                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            @endif
        </div>
        {{-- end modal tambah laporan fondasi --}}
    @endteleport
</section>
