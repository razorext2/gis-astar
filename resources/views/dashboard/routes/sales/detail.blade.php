@extends('dashboard.layoutsDash.app')
@section('content')
    <livewire:handler.routes.sales-detail :kodePegawai="$pegawai->kode_pegawai" />
@endsection
