@extends('dashboard.pegawai.detail')
@section('menus')
	<div id="attendance-accordion-icon" data-accordion="collapse">

		<h2 id="attendance-accordion-icon-heading-1">
			<button type="button"
				class="flex w-full gap-3 rounded-t-xl border border-b-0 border-gray-200 bg-white p-5 transition-all duration-300 ease-in-out dark:border-gray-700 dark:bg-dark-primary"
				data-accordion-target="#attendance-accordion-icon-body-1" aria-expanded="true"
				aria-controls="attendance-accordion-icon-body-1">
				<h3 class="w-full text-left font-semibold uppercase text-gray-800 dark:text-white">
					Absensi Masuk {{ $pegawai->full_name }}
				</h3>
				<x-icons.carred-down data-accordion-icon class="h-6 w-6" />
			</button>
		</h2>
		<div id="attendance-accordion-icon-body-1" aria-labelledby="attendance-accordion-icon-heading-1">
			<div class="border border-b-0 border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-dark-primary">
				<livewire:attendance-in-table :kodePegawai="$pegawai->kode_pegawai" />
			</div>
		</div>

		<h2 id="attendance-accordion-icon-heading-2">
			<button type="button"
				class="flex w-full gap-3 rounded-b-xl border border-gray-200 bg-white p-5 transition-all duration-300 ease-in-out focus:rounded-none dark:border-gray-700 dark:bg-dark-primary"
				data-accordion-target="#attendance-accordion-icon-body-2" aria-expanded="false"
				aria-controls="attendance-accordion-icon-body-2">
				<h3 class="w-full text-left font-semibold uppercase text-gray-800 dark:text-white">
					Absensi Keluar {{ $pegawai->full_name }}
				</h3>
				<x-icons.carred-down data-accordion-icon class="h-6 w-6" />
			</button>
		</h2>
		<div id="attendance-accordion-icon-body-2" class="hidden" aria-labelledby="attendance-accordion-icon-heading-2">
			<div class="rounded-b-xl border border-t-0 border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-dark-primary">
				<livewire:attendance-out-table :kodePegawai="$pegawai->kode_pegawai" />
			</div>
		</div>
	</div>
@endsection
