@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to Borrow Leave Request, Livewire: handler.leave-request.borrow --}}

    @livewire('handler.leave-request.borrow')
@endsection
