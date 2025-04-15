@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="w-full rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 md:p-6">
		@livewire('handler.point.technician.redeem')
	</div>
@endsection
