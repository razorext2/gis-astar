<div class="w-full">
    <div
        class="mb-2 w-full rounded-xl bg-white p-2 shadow-lg ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 lg:mb-4 lg:p-4">

        <h2 class="mb-2 font-medium text-gray-700 dark:text-white">Info Customer</h2>

        <form wire:submit.prevent="store"
            class="rounded-lg p-2 ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700 lg:p-4">
            <div class="mb-2 lg:mb-4">
                <x-input.basic id="name" wire:model="name" type="text" name="name"
                    placeholder="Isi dengan nama customer..." required>
                    Nama
                </x-input.basic>

                @error('name')
                    <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                @enderror
            </div>

            <div class="mb-2 lg:mb-4">
                <x-input.basic id="email" wire:model="email" type="email" name="email"
                    placeholder="Isi dengan email customer..." required>
                    Email
                </x-input.basic>

                @error('email')
                    <span class="mt-2 text-xs text-red-500"> {{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-2 lg:gap-4">
                <x-button.success type="submit" id="save">
                    <span wire:loading.remove wire:target="store">Simpan</span>
                    <span wire:loading wire:target="store">Menyimpan...</span>
                </x-button.success>
            </div>
        </form>
    </div>

    <div
        class="relative max-h-[575px] w-full overflow-y-auto rounded-xl bg-white p-2 shadow-lg ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 lg:p-4">

        <h2 class="mb-2 font-medium text-gray-700 dark:text-white lg:mb-4">Rekap Laporan</h2>

        <div class="flex flex-col gap-6">
            @foreach ($this->assigments() as $assignment)
                {{-- ASSIGNMENT CARD --}}
                <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">

                    {{-- HEADER --}}
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Nomor VT
                                </p>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $assignment->nomor_vt }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Tipe Laporan
                                </p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ ucfirst($assignment->laporan_type) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Assigned At
                                </p>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($assignment->assign_at)->isoFormat('DD MMM YYYY HH:mm') }}
                                </p>
                            </div>

                            <span
                                class="inline-flex w-fit rounded-md bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900 dark:text-blue-200">
                                {{ ucfirst($assignment->status) }}
                            </span>

                        </div>
                    </div>

                    {{-- DAILY REPORT LIST --}}
                    <div class="relative divide-y divide-gray-200 dark:divide-gray-700">

                        {{-- vertical line --}}
                        <div class="absolute left-4 top-0 h-full w-px bg-gray-200 dark:bg-gray-700"></div>

                        @forelse ($assignment->dailyReports as $index => $daily)
                            <div class="relative py-5 pl-10 pr-4">

                                {{-- DOT --}}
                                <span class="absolute left-[10px] top-6 h-3 w-3 rounded-full bg-blue-500"></span>

                                {{-- CONTENT --}}
                                <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">

                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Laporan #{{ $index + 1 }}
                                        </p>

                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($daily->report_date)->isoFormat('dddd, DD MMM YYYY') }}
                                        </p>
                                    </div>

                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        Submitted:
                                        {{ $daily->submitted_at ? \Carbon\Carbon::parse($daily->submitted_at)->isoFormat('HH:mm') : '-' }}
                                    </div>

                                    <span
                                        class="inline-flex w-fit rounded-md bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-900 dark:text-green-200">
                                        {{ ucfirst($daily->status) }}
                                    </span>

                                </div>


                                {{-- HOURLY REPORT --}}
                                <div class="mt-4 flex flex-col gap-3">
                                    @forelse ($daily->hourlyReport as $hour)
                                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">

                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($hour->start_time)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($hour->end_time)->format('H:i') }}
                                            </p>

                                            {{-- <p class="mt-1 text-sm text-gray-800 dark:text-gray-200">
                                                {{ $hour->activity }}
                                            </p> --}}

                                            @if ($hour->notes)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {!! nl2br($hour->notes) !!}
                                                </p>
                                            @endif

                                        </div>

                                    @empty
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada aktivitas.
                                        </p>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                Belum ada laporan harian.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        {{-- form tanda tangan, nama dan email --}}
        <div class="mt-2 lg:mt-4">
            @if (!$model->assignTo->hasBeenSigned())
                <div class="my-4 flex justify-center">
                    @if ($model->assign_to !== auth()->user()->id)
                        {{-- kalo assignTo dan id auth gak sama --}}
                        <p class="text-center text-sm italic text-red-500 lg:text-base">
                            Staf terkait belum melengkapi tanda tangan digital. Hubungi staf terkait untuk melengkapi
                            tanda tangan digital di Profil.
                        </p>
                    @else
                        <form id="signature-form" method="get" action="{{ route('profile.edit') }}">
                            @csrf
                        </form>

                        <x-button.primary id="btn-update-signature" type="submit" :form="'signature-form'">
                            Update TTD Staff
                        </x-button.primary>
                    @endif
                </div>
            @endif

            <div>
                <h2 class="mb-2 text-center text-gray-900 dark:text-white">
                    Tanda Tangan Customer
                </h2>

                @if (!$model->hasBeenSigned())
                    <form action="{{ $model->getSignatureRoute() }}" method="POST">
                        @csrf
                        <x-creagia-signature-pad border-color="#eaeaea" pad-classes="rounded-xl border-2"
                            button-classes="bg-gray-100 px-4 py-2 rounded-xl" clear-name="Clear" submit-name="Submit" />
                    </form>

                    @push('script')
                        <script src="{{ asset('vendor/sign-pad/sign-pad.min.js') }}"></script>
                    @endpush
                @else
                    <img class="mx-auto h-48 w-fit rounded-lg bg-white"
                        src="{{ asset('storage/' . $model->signature->getSignatureImagePath()) }}" />
                @endif
            </div>
        </div>

        {{-- kontainer untuk tombol kirim email --}}
        @if ($model->hasBeenSigned() && $model->assignTo->hasBeenSigned())
            <div class="mt-2 flex justify-center gap-x-2 lg:mt-4 lg:gap-x-4">
                @livewire('handler.spk.daily-report.pdf.laporan-harian', ['assignmentId' => $model->id], key($model->id))

                <x-button.success wire:click.prevent="sentPdfToEmail" id="btn-sent-report-to-email">
                    <span wire:loading.remove wire:target="sentPdfToEmail">Kirim PDF</span>
                    <span wire:loading wire:target="sentPdfToEmail">Mengirim Email...</span>
                </x-button.success>

            </div>
        @endif

    </div>
</div>
