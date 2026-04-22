@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="mt-4 w-full">
        <livewire:handler.placement.create />
    </div>
@endsection
@push('script')
    @vite(['resources/js/pages/placement/placement-map.js'])
@endpush
