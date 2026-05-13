{{-- Goal: Quartal-based redeem wizard UI, Livewire: Redeem, Alpine: step transitions --}}
<div class="flex flex-col gap-4">

    <livewire:utils.stepper :step="$step" key="technician-point-redeem-stepper.{{ $step }}" />

    {{-- Top navigation has been moved to step-specific footers for better flow --}}

    {{-- ─── STEP 1: Pilih Quartal ────────────────────────────────────────── --}}
    @if ($step == 1)
        @include('livewire.handler.point.technician.partials.redeem-step-1')
    @endif

    {{-- ─── STEP 2: Preview & Select ─────────────────────────────────────── --}}
    @if ($step == 2)
        @include('livewire.handler.point.technician.partials.redeem-step-2')
    @endif

    {{-- ─── STEP 3: Summary ──────────────────────────────────────────────── --}}
    @if ($step == 3)
        @include('livewire.handler.point.technician.partials.redeem-step-3')
    @endif

</div>
