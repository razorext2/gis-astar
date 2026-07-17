@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:handler.placement.create />
@endsection
@push('script')
    @vite(['resources/js/pages/placement/placement-map.js'])
@endpush
