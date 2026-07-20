@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'dashboard'])

    <div class="flex flex-col gap-4 mt-4">
        <x-signature-reminder class="mb-4" />

        {{-- Greetings Section --}}
        <livewire:utils.greetings class="mb-4" />
    </div>
@endsection
