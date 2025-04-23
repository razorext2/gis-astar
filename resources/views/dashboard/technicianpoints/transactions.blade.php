@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="w-full rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 md:p-6">

		<header class="mb-4 flex items-center justify-between">
			<p class="text-lg font-semibold text-gray-900 dark:text-white lg:text-xl">
				Riwayat Transaksi Poin Keluar
			</p>
		</header>

		<livewire:table-refresher table-name="PointTransactionsTable" />
	</div>
@endsection
