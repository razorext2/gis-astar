@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to Leave Request Detail, Livewire: handler.leave-request.show --}}

    @livewire('handler.leave-request.show', ['id' => request()->route('my_request')])
@endsection
