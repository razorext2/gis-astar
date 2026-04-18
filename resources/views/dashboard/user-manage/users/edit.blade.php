@extends('dashboard.layoutsDash.app')

@section('content')
    <livewire:handler.user.edit :user="$user" />
@endsection
