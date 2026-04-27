@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to Approval Center process detail, Livewire: handler.leave-request.approval-center.show --}}

    @livewire('handler.leave-request.approval-center.show', ['id' => Route::current()->parameter('approval_center')])
@endsection
