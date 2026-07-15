@extends('dashboard.layoutsDash.app')

@section('content')
    {{-- Komponen ini secara mandiri merender title container form serta integrasi full halamannya --}}
    <livewire:handler.teams.create />
@endsection
