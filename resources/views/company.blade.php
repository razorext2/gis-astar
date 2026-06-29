{{-- Goal: Single-page company profile (Floema-inspired), Livewire: None, Alpine: Yes --}}
<x-company.layout title="PT. Indodacin Presisi Utama — Presisi dalam Setiap Solusi">
    @include('company.navbar')
    @include('company.hero')
    @include('company.about')
    @include('company.services')
    @include('company.showcase')
    @include('company.history')
    @include('company.contact')
    @include('company.footer')
</x-company.layout>
