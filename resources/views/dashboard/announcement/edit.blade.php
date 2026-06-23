@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:handler.announcement.edit :announcement="$announcement" />
@endsection
