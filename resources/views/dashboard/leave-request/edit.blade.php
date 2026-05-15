@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to Edit Leave Request, Livewire: handler.leave-request.edit --}}

    @livewire('handler.leave-request.edit', ['id' => request()->route('my_request')])
@endsection
