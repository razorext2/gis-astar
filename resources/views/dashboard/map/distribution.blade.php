@extends('dashboard.layoutsDash.app')
@section('content')
    <div
        class="flex w-full flex-col gap-4 rounded-xl border border-zinc-200 bg-white p-2 shadow-md dark:border-zinc-800 dark:bg-dark-primary dark:shadow-none md:p-6">
        <h2 class="w-full text-lg font-semibold text-gray-900 dark:text-white">Peta Penyebaran Staff Operasional</h2>

        @livewire('handler.route.all-employees')
    </div>
@endsection
