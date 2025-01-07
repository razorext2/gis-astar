@extends('dashboard.collect.index')
@section('subcontent')
	<div class="col-span-2" x-data="{ openRow: null }">
		<x-dashboard.table id="dataTable" :tablename="[
		    '0' => '#',
		    '1' => 'Aksi',
		    '2' => 'No SR',
		    '3' => 'Customer',
		    '4' => 'Detail Tagihan',
		    '5' => 'Tanggal Penagihan',
		]" />
	</div>
@endsection
@push('script')
	<script>
		const index = "{{ route('collect.showdata') }}";
	</script>
	@vite(['resources/js/collect/index.js'])
@endpush
