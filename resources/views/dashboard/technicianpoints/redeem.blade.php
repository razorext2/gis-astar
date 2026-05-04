@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="w-full rounded-xl bg-white/60 p-4 shadow-md border border-zinc-200 backdrop-blur-md dark:bg-dark-primary/60 dark:shadow-none dark:border-zinc-800 md:p-6">
        @livewire('handler.point.technician.redeem')
    </div>
@endsection
