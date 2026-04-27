@extends('dashboard.layoutsDash.app')
@section('content')
    {{-- Goal: Bridge view to Manage Leave Balances, Livewire: handler.leave-request.manage-balances.index --}}
    {{-- Quick Stats --}}
    @livewire('components.card', ['type' => 'manage-leave-balance'])

    @livewire('handler.leave-request.manage-balances.index')
@endsection
