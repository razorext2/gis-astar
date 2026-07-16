{{-- Goal: Tanda tangan customer untuk SPK Daily Report, Livewire: App\Livewire\Handler\Spk\DailyReport\Signature, Alpine: N/A --}}
<div class="w-full">
    <div class="mb-2 w-full rounded-xl border border-zinc-200 p-2 shadow-md dark:border-zinc-800 lg:mb-4 lg:p-4"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <h2 class="mb-2 font-medium text-gray-700 dark:text-white">Info Customer</h2>

        <form wire:submit.prevent="store"
            class="rounded-lg border border-zinc-200 p-2 dark:border-zinc-800 dark:bg-gray-800 lg:p-4">
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
                <x-button.success type="submit" id="save" wire:loading.attr="disabled" wire:target="store">
                    <x-slot name="icon">
                        <x-icons.plus wire:loading.remove wire:target="store" class="icon h-5 w-5" />
                        <x-icons.loading wire:loading wire:target="store" class="h-4 w-4 animate-spin" />
                    </x-slot>

                    <span wire:loading.remove wire:target="store">Simpan</span>
                    <span wire:loading wire:target="store">Menyimpan...</span>
                </x-button.success>
            </div>
        </form>
    </div>

    <div class="relative max-h-[575px] w-full overflow-y-auto rounded-xl border border-zinc-200 p-2 shadow-md dark:border-zinc-800 lg:p-4"
        x-bind:class="dynamicBg ?
            'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
            'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

        <h2 class="mb-2 font-medium text-gray-700 dark:text-white lg:mb-4">Rekap Laporan</h2>

        <div class="flex flex-col gap-6">
            @foreach ($this->assigments() as $assignment)
                {{-- ASSIGNMENT CARD --}}
                <div class="rounded-xl border border-zinc-200 shadow dark:border-zinc-800 dark:bg-gray-800"
                    x-bind:class="dynamicBg ?
                        'bg-glass-light dark:bg-glass-dark border-glass-border-light dark:border-glass-border-dark backdrop-blur-md shadow-sm' :
                        'bg-white dark:bg-dark-primary border-zinc-200 dark:border-zinc-800 shadow-sm'">

                    {{-- HEADER --}}
                    <div class="border-b border-zinc-200 px-6 py-4 dark:border-zinc-800">
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
                                        <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-800">

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
                    @php
                        $currentRoute = request()->route()->getName();
                        $redirectUrl = route('daily-report.daily', ['id' => $model->id]);
                        if ($currentRoute === 'report.general.customer-assignment') {
                            $redirectUrl = route('report.general.daily', ['id' => $model->id]);
                        }
                    @endphp
                    <form action="{{ $model->getSignatureRoute() }}" method="POST">
                        @csrf
                        <x-creagia-signature-pad border-color="#eaeaea" pad-classes="rounded-xl border-2"
                            button-classes="bg-gray-100 mt-2.5 px-4 py-2 rounded-xl" clear-name="Hapus"
                            submit-name="Simpan" redirect-url="{{ $redirectUrl }}" />
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
                <livewire:handler.spk.daily-report.pdf.laporan-harian :assignmentId="$model->id" :wire:key="$model->id" />

                <x-button.success wire:click.prevent="sentPdfToEmail" id="btn-sent-report-to-email"
                    wire:loading.attr="disabled" wire:target="sentPdfToEmail">
                    <x-slot name="icon">
                        <x-icons.letter-sent wire:loading.remove wire:target="sentPdfToEmail" class="icon h-5 w-5" />
                        <x-icons.loading wire:loading wire:target="sentPdfToEmail" class="h-4 w-4 animate-spin" />
                    </x-slot>

                    <span wire:loading.remove wire:target="sentPdfToEmail">Kirim PDF</span>
                    <span wire:loading wire:target="sentPdfToEmail">Mengirim Email...</span>
                </x-button.success>

            </div>
        @endif

    </div>
</div>
