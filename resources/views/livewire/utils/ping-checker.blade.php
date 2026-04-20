<div class="cursor-pointer space-y-1" x-data="pingCheckerComponent()" x-init="initPing()" x-on:click="checkPing()">
    <div data-popover-target="popover-ping" type="button"
        class="flex shrink-0 flex-nowrap items-center justify-center gap-1.5 whitespace-nowrap transition-colors duration-300"
        :class="textColor">

        <!-- Pulse dot indicator -->
        <span class="relative flex h-2 w-2 shrink-0">
            <span :class="[bgColor, isChecking ? 'animate-ping' : '']"
                class="absolute inline-flex h-full w-full rounded-full opacity-75"></span>
            <span :class="bgColor" class="relative inline-flex h-2 w-2 rounded-full"></span>
        </span>

        <!-- Text with fixed minimum width to avoid layout jumping -->
        <p class="w-16 shrink-0 whitespace-nowrap text-left text-sm font-semibold" x-text="statusText"></p>
    </div>

    <div data-popover id="popover-ping" role="tooltip"
        class="shadow-xs invisible absolute z-10 inline-block w-64 rounded-xl border border-zinc-200 bg-white/90 p-3 text-sm text-zinc-800 opacity-0 backdrop-blur-md transition-opacity duration-300 ease-in-out dark:border-zinc-700 dark:bg-zinc-900/90 dark:text-white dark:shadow-none">
        <div class="flex flex-col gap-1">
            <p class="font-bold">Status Koneksi Database Central</p>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Silakan klik untuk memperbarui secara manual. Pengecekan
                otomatis berjalan tiap 30 detik.</p>
        </div>
    </div>
</div>

<script>
    function pingCheckerComponent() {
        return {
            latency: 0,
            isChecking: false,
            intervalId: null,

            get textColor() {
                if (this.isChecking && this.latency === 0) return 'text-zinc-500 dark:text-zinc-400';
                if (this.latency === 0) return 'text-zinc-500 dark:text-zinc-400';
                if (this.latency < 100) return 'text-emerald-500 dark:text-emerald-400';
                if (this.latency < 300) return 'text-amber-500 dark:text-amber-400';
                return 'text-red-500 dark:text-red-400';
            },

            get bgColor() {
                if (this.isChecking && this.latency === 0) return 'bg-zinc-500 dark:bg-zinc-400';
                if (this.latency === 0) return 'bg-zinc-500 dark:bg-zinc-400';
                if (this.latency < 100) return 'bg-emerald-500 dark:bg-emerald-400';
                if (this.latency < 300) return 'bg-amber-500 dark:bg-amber-400';
                return 'bg-red-500 dark:bg-red-400';
            },

            get statusText() {
                if (this.isChecking && this.latency === 0) return '...';
                if (this.latency === 0) return 'Offline';
                if (this.latency > 1000) return 'RTO';
                return this.latency + ' ms';
            },

            initPing() {
                this.checkPing();
                // Polling "real-time" tiap 30 detik tanpa membebani server lokal
                this.intervalId = setInterval(() => {
                    this.checkPing();
                }, 30000);
            },

            async checkPing() {
                if (this.isChecking && this.latency !== 0) return;
                this.isChecking = true;

                const start = performance.now();

                try {
                    // Bypass Laravel server load dengan cara ping langsung via browser ke eksternal
                    // menggunakan mode 'no-cors' untuk menghindari policy block
                    await fetch('https://attendance.indodacin.com/status', {
                        method: 'HEAD',
                        mode: 'no-cors',
                        cache: 'no-store'
                    });

                    const end = performance.now();

                    let ms = Math.round(end - start);
                    this.latency = Math.max(1, ms);
                } catch (error) {
                    this.latency = 9999; // Request timeout atau koneksi user putus
                } finally {
                    this.isChecking = false;
                }
            }
        }
    }
</script>
