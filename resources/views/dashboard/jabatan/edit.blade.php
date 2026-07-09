{{-- Goal: Render edit jabatan dashboard page wrapper, Livewire: Handler.Jabatan.Edit --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    <div class="w-full">
        <livewire:handler.jabatan.edit :jabatan="$jabatan" />
    </div>
@endsection
