@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="xl:w-6/12 2xl:w-1/3">
        <livewire:handler.jabatan.edit :jabatan="$jabatan" />
    </div>
@endsection
