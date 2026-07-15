{{-- Goal: Today's attendance list and maps, Livewire: handler.attendance.today, Alpine: dynamicBg --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:components.card type="attendancetoday" />

    <livewire:handler.attendance.today />
@endsection
