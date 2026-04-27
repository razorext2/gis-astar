@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to My Leave Requests list, Livewire: handler.leave-request.index --}}
    {{-- Stats Cards for My Leave Requests --}}
    @livewire('components.card', ['type' => 'my-leave-request'])

    @livewire('handler.leave-request.index')
@endsection
