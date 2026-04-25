@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="w-full rounded-xl bg-white p-4 shadow-md ring-1 ring-zinc-200 dark:bg-dark-primary dark:shadow-none dark:ring-zinc-800 md:p-6">
        @livewire('handler.point.technician.redeem')
    </div>
@endsection
