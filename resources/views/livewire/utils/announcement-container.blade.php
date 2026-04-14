<div id="announcement-container" x-data="{ hasVisibleChildren: false }" x-init="const checkVisibility = () => {
    hasVisibleChildren = Array.from($el.children).some(child => {
        return !child.classList.contains('hidden') && child.nodeType === 1;
    });
};
const observer = new MutationObserver(checkVisibility);
observer.observe($el, { attributes: true, subtree: true, childList: true });
checkVisibility();"
    :class="hasVisibleChildren ? 'mb-4 space-y-4' : 'mb-0'">
    @if ($row)
        <x-notification-alert :id="'notification-alert'" type="announcement" wire:poll.300s>
            <x-slot name="title">
                {{ $row->title }}
            </x-slot>
            <x-slot name="desc">
                {{ $row->description }}
            </x-slot>
        </x-notification-alert>
    @endif

    <x-notification-alert class="hidden" :id="'offline-alert'" type="offline" wire:offline.class.remove="hidden">
        <x-slot name="title">
            KONEKSI TERPUTUS
        </x-slot>
        <x-slot name="desc">
            Kamu sedang dalam kondisi offline. Periksa koneksi internetmu untuk melanjutkan aktivitas.
        </x-slot>
    </x-notification-alert>
</div>
