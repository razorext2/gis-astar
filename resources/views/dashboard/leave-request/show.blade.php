@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to Leave Request Detail, Livewire: handler.leave-request.show --}}

    @livewire('handler.leave-request.show', ['id' => is_object(request()->route('my_request')) ? request()->route('my_request')->id : request()->route('my_request')])
@endsection
