@extends('dashboard.pegawai.detail')
@section('menus')
@section('menus')
    <div class="space-y-4 lg:space-y-6" id="payroll" role="tabpanel">
        {{-- Salary Overview --}}
        <div
            class="group relative overflow-hidden rounded-3xl border border-white/30 bg-white/70 p-6 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60 lg:p-8">
            <div class="mb-6 flex items-center justify-between border-b border-white/20 pb-4 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-1 rounded-full bg-indigo-600"></div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Informasi Payroll</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $pegawai->full_name }}</p>
                    </div>
                </div>
                @if (auth()->user()->can('salary-edit'))
                    <a class="flex h-10 items-center gap-2 rounded-xl bg-indigo-50 px-4 text-xs font-bold text-indigo-600 transition-all hover:bg-indigo-600 hover:text-white dark:bg-indigo-900/30 dark:text-indigo-400 dark:hover:bg-indigo-600 dark:hover:text-white"
                        href="{{ route('salary.edit', $pegawai->id) }}">
                        <x-icons.file-pen class="h-4 w-4" />
                        <span>Edit Salary</span>
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:gap-4">
                @php
                    $payrollData = [
                        ['label' => 'Kode Pegawai', 'value' => $pegawai->kode_pegawai],
                        ['label' => 'Payroll Type', 'value' => ucfirst($pegawai->salaryRelasi->payroll_type ?? 'N/A')],
                        [
                            'label' => 'Base Salary',
                            'value' => $pegawai->salaryRelasi
                                ? Number::currency($pegawai->salaryRelasi->salary_fee ?? 0, 'IDR', 'id')
                                : 'N/A',
                        ],
                        [
                            'label' => 'Periode',
                            'value' => $pegawai->salaryRelasi
                                ? \Carbon\Carbon::parse($pegawai->salaryRelasi->period)
                                    ->locale('id')
                                    ->isoFormat('MMMM YYYY')
                                : 'N/A',
                        ],
                    ];
                @endphp

                @foreach ($payrollData as $item)
                    <div
                        class="rounded-2xl border border-white/20 bg-white/40 p-4 shadow-sm transition-all hover:bg-white/60 dark:border-zinc-800 dark:bg-white/5 dark:hover:bg-white/10">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">
                            {{ $item['label'] }}</p>
                        <p class="text-base font-semibold text-gray-700 dark:text-gray-200">
                            {{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Allowances --}}
        <div
            class="rounded-3xl border border-white/30 bg-white/70 p-6 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60 lg:p-8">
            <div
                class="overflow-hidden rounded-2xl border border-white/20 bg-white/30 dark:border-zinc-800 dark:bg-black/10">
                @include('dashboard.pegawai.details.components.allowances-section')
            </div>
        </div>

        {{-- Deductions --}}
        <div
            class="rounded-3xl border border-white/30 bg-white/70 p-6 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60 lg:p-8">
            <div
                class="overflow-hidden rounded-2xl border border-white/20 bg-white/30 dark:border-zinc-800 dark:bg-black/10">
                @include('dashboard.pegawai.details.components.deductions-section')
            </div>
        </div>

        {{-- Total --}}
        <div
            class="rounded-3xl border border-white/30 bg-white/70 p-6 shadow-xl backdrop-blur-xl dark:border-white/10 dark:bg-zinc-900/60 lg:p-8">
            <div
                class="overflow-hidden rounded-2xl border border-white/20 bg-white/30 dark:border-zinc-800 dark:bg-black/10">
                @include('dashboard.pegawai.details.components.total-payroll')
            </div>
        </div>
    </div>
@endsection
