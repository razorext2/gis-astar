{{-- Goal: Bridge view to Attendance Inquiry Approval Center Show, Livewire: handler.attendance-inquiry.approval-center-show, Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('handler.attendance-inquiry.approval-center-show', ['inquiry' => $inquiry])
@endsection
