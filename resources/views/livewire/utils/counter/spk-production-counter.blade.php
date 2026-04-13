<div wire:poll.600s>
    <span class="ms-2 inline-flex items-center justify-center rounded-lg bg-orange-200 px-3 text-[10px] text-orange-800"
        data-popover-target="sidebar-badge-{{ $counterKey }}">
        {{ $count }}
    </span>

    <div class="shadow-xs invisible absolute z-10 inline-block w-64 rounded-lg border border-gray-200 bg-white text-sm text-gray-500 opacity-0 transition-opacity duration-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400"
        id="sidebar-badge-{{ $counterKey }}" data-popover role="tooltip">
        <div class="px-3 py-2">
            <p>Kamu memiliki {{ $count }} SPK yang belum punya progres produksi.</p>
        </div>
        <div data-popper-arrow></div>
    </div>
</div>
