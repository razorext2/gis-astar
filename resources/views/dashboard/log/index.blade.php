@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		<div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 lg:p-4">
			<livewire:table-refresher />
		</div>
	</div>
@endsection
