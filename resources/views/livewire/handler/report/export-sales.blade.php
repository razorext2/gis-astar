{{-- Goal: View export laporan sales, Livewire: Handler\Report\ExportSales, Alpine: None --}}
<div>
    <x-filter.report-export-form reportTitle="Laporan Sales" :filterOptions="$filterOptions" :users="$users" />
</div>
