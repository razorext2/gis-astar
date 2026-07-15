@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to Approval Center list, Livewire: handler.leave-request.approval-center.index --}}
    {{-- Stats Cards for Approval Center --}}
    <livewire:components.card type="approval-center-leave" />

    <livewire:handler.leave-request.approval-center.index />
@endsection
