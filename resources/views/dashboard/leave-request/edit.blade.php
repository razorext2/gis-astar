@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to Edit Leave Request, Livewire: handler.leave-request.edit --}}

    <livewire:handler.leave-request.edit :id="is_object(request()->route('my_request')) ? request()->route('my_request')->id : request()->route('my_request')" />
@endsection
