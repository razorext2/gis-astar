/**
 * Goal: Show full-size image in a SweetAlert2 modal on click.
 * Caller: app.js livewire:navigated handler and individual page entry points.
 * Deps: SweetAlert2 (global window.Swal)
 *
 * Uses native event delegation on document.body — body persists across
 * wire:navigate SPA swaps so the listener is always active once registered.
 * Uses a named handler reference so repeated calls are safe (addEventListener
 * ignores duplicate registrations of the exact same function reference).
 */

function handleZoomClick(e) {
    const target = e.target.closest('#documentations');
    if (!target) return;

    const url = target.dataset.url;
    if (!url) return;

    Swal.fire({
        showCancelButton: false,
        showConfirmButton: false,
        html: `<img src="${url}" onerror="this.onerror=null; this.src='/assets/img/noImage.webp';" class="w-full mx-auto rounded-xl" loading="lazy" />`,
    });
}

export function zoomImage() {
    // Passing the same named function reference means the browser deduplicates
    // the listener automatically — safe to call on every livewire:navigated.
    document.body.addEventListener('click', handleZoomClick);
}