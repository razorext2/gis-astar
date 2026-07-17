{{-- Goal: Dashboard page displaying greetings, quick actions, attendance chart, and recent activity, Livewire: Line, recent-spk, financial-glance, technician-leaderboard, admin-attendance-overview, Alpine: None --}}
@extends('dashboard.layoutsDash.app')
@section('content')
    @livewire('components.card', ['type' => 'dashboard'])

    <div class="flex flex-col">
        <x-signature-reminder class="mb-4" />

        {{-- Greetings Section --}}
        <livewire:utils.greetings class="mb-4" />

        @php
            $showQuickActions =
                auth()->user()->can('spk-create') ||
                auth()->user()->can('invoice-list') ||
                auth()->user()->can('spk-approve') ||
                auth()->user()->can('point-redeem');
            $showRecentSpk = auth()->user()->can('spk-list');
            $showRightColumn =
                auth()->user()->can('invoice-list') ||
                auth()->user()->can('technician-list') ||
                auth()->user()->can('point-approve');
        @endphp

        @if ($showQuickActions)
            <livewire:dashboard.quick-actions />
        @endif

        <div class="mb-4 flex flex-col items-stretch lg:grid lg:grid-cols-3 lg:gap-x-4">
            {{-- Livewire Chart --}}
            <livewire:chart.attendance-chart />
            <!-- End Chart Section -->

            <!-- Attendance Overview Section -->
            <livewire:dashboard.admin-attendance-overview />
            <!-- End Attendance Overview Section -->
        </div>

        {{-- Command Center Widgets --}}
        @if ($showRecentSpk || $showRightColumn)
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                {{-- SPK Terkini takes 2 columns --}}
                @if ($showRecentSpk)
                    <livewire:dashboard.recent-spk :showRightColumn="$showRightColumn" />
                @endif

                {{-- Right column for Financial and Leaderboard --}}
                @if ($showRightColumn)
                    <div
                        class="{{ $showRecentSpk ? '' : 'lg:col-span-3 lg:flex-row lg:items-start lg:[&>*]:flex-1' }} flex flex-col gap-4">
                        @can('invoice-list')
                            <livewire:dashboard.financial-glance />
                        @endcan

                        @if (auth()->user()->can('technician-list') || auth()->user()->can('point-approve'))
                            <livewire:dashboard.technician-leaderboard />
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Signal popup FABs to auto-open on this page --}}
    <script>
        (() => {
            const fireAutoPop = () => window.dispatchEvent(new CustomEvent('enable-autopop'));
            if (document.readyState === 'complete') {
                fireAutoPop();
            } else {
                window.addEventListener('load', fireAutoPop, { once: true });
            }
            document.addEventListener('livewire:navigated', fireAutoPop, { once: true });
        })();
    </script>
@endsection
