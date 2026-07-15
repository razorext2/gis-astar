{{-- Goal: Bridge view to Attendance Inquiry Approval Center list, Livewire: handler.attendance-inquiry.approval-center-index, Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="attendance-inquiry-approval-center" />

    <livewire:handler.attendance-inquiry.approval-center-index />
@endsection
