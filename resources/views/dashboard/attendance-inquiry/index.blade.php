{{-- Goal: Bridge view to My Attendance Inquiries list, Livewire: handler.attendance-inquiry.index, Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="my-attendance-inquiry" />

    <livewire:handler.attendance-inquiry.index />
@endsection
