@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to My Leave Requests list, Livewire: handler.leave-request.index --}}

    @livewire('handler.leave-request.index')
@endsection
