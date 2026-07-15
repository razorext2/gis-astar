{{-- Goal: Bridge view to Show Attendance Inquiry, Livewire: handler.attendance-inquiry.show, Alpine: - --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:handler.attendance-inquiry.show :inquiry="$my_inquiry" />
@endsection
