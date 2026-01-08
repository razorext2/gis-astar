<div class="cursor-pointer space-y-1" x-data="pingChecker()" x-init="startPolling()" x-on:click="startPolling()">
    <p data-popover-target="popover-default" type="button" class="{{ $pingClass }} text-sm">
        {{ $latency == 0 ? 'Loading...' : $latency . ' ms' }}
    </p>

    <div data-popover id="popover-default" role="tooltip"
        class="shadow-xs invisible absolute z-10 inline-block w-64 rounded-lg bg-white text-sm text-gray-800 opacity-0 ring-1 ring-gray-200 transition-opacity duration-300 ease-in-out dark:bg-dark-primary dark:text-white dark:shadow-none dark:ring-gray-700">
        <div class="px-3 py-2">
            <p>Silahkan klik untuk memperbarui <span class="font-semibold">ping</span> anda.</p>
        </div>
    </div>
</div>

<script>
    function pingChecker() {
        return {
            startPolling() {
                // Jalankan pertama kali saat halaman load
                polling();
            }
        }
    }

    async function polling() {
        const start = performance.now();

        try {
            await fetch('{{ route('ping.checker') }}');
            const end = performance.now();
            const latency = Math.round(end - start);

            Livewire.dispatch('updateLatency', {
                ms: latency
            });
        } catch (error) {
            console.log(error);
            Livewire.dispatch('updateLatency', {
                ms: 9999
            });
        }
    }
</script>
