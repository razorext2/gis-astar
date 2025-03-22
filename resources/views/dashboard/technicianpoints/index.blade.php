@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="w-full max-w-xl rounded-xl bg-white p-4 pl-8 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 md:p-6 md:pl-10">
		@livewire('handler.point.index')
	</div>
@endsection
