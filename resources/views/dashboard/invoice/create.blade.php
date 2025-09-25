@extends('dashboard.layoutsDash.app')
@section('content')
	<div
		class="w-full rounded-xl bg-white p-4 shadow-md ring-1 ring-gray-200 dark:bg-dark-primary dark:shadow-none dark:ring-gray-700 sm:p-6 md:max-w-lg lg:max-w-xl xl:max-w-2xl">

		@livewire('handler.invoice.create')
	</div>
@endsection
