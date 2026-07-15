@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="relative grid grid-cols-1 gap-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-2 dark:border-zinc-800 dark:bg-dark-primary md:p-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white"> Fetch Update </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400"> Perbandingan data dari API dan data yang ada didatabase.
            </p>
            {{-- livewire --}}
            <livewire:handler.technician.fetch :id="$id" />
        </div>
    </div>
@endsection
