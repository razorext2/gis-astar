{{-- Goal: Landing page list item with success check icon, Livewire: None, Alpine: None --}}
<li class="flex items-center space-x-3 rtl:space-x-reverse">
    <x-icons.check class="h-3.5 w-3.5 flex-shrink-0 text-green-500" />
    <span>{{ $slot }}</span>
    <span class="ms-2" id="{{ $id }}"></span>
</li>
