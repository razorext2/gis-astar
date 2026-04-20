@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:handler.routes.driver-detail :userId="$pegawai->userRelasi->id" />
@endsection
