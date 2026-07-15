{{-- Goal: Render latency ping checker status with absolute clamped popover, Livewire: Utils\PingChecker, Alpine: Yes --}}
<div id="ping-checker-trigger" class="relative cursor-pointer max-[420px]:hidden" x-data="{
    latency: 0,
    isChecking: false,
    intervalId: null,
    showPopover: false,
    popoverStyle: '',

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
        this.intervalId = setInterval(() => {
            this.checkPing();
        }, 30000);

        // Re-calculate position on window events if open
        window.addEventListener('resize', () => {
            if (this.showPopover) this.updatePosition();
        }, {
            passive: true
        });
        window.addEventListener('scroll', () => {
            if (this.showPopover) this.updatePosition();
        }, {
            passive: true
        });
    },

    updatePosition() {
        const trigger = document.getElementById('ping-checker-trigger');
        if (!trigger) return;
        const rect = trigger.getBoundingClientRect();
        const top = rect.bottom + 12;

        const popoverWidth = 256; // w-64 is 16rem = 256px
        const screenPadding = 16;

        let left = (rect.left + rect.width / 2) - (popoverWidth / 2);

        // Clamp to prevent left or right overflow on mobile screens
        left = Math.max(screenPadding, left);
        left = Math.min(window.innerWidth - popoverWidth - screenPadding, left);

        this.popoverStyle = `position:fixed;top:${top}px;left:${left}px;`;
    },

    async checkPing() {
        if (this.isChecking && this.latency !== 0) return;
        this.isChecking = true;

        const start = performance.now();

        try {
            await fetch('https://attendance.indodacin.com/status', {
                method: 'HEAD',
                mode: 'no-cors',
                cache: 'no-store'
            });

            const end = performance.now();

            let ms = Math.round(end - start);
            this.latency = Math.max(1, ms);
        } catch (error) {
            this.latency = 9999;
        } finally {
            this.isChecking = false;
        }
    }
}"
    x-init="initPing()" x-on:click="checkPing()" @mouseenter="showPopover = true; updatePosition()"
    @mouseleave="showPopover = false">
    <div class="flex shrink-0 flex-nowrap items-center justify-center gap-1.5 whitespace-nowrap transition-colors duration-300"
        :class="textColor">

        <!-- Pulse dot indicator -->
        <span class="relative flex h-2 w-2 shrink-0">
            <span :class="[bgColor, isChecking ? 'animate-ping' : '']"
                class="absolute inline-flex h-full w-full rounded-full opacity-75"></span>
            <span :class="bgColor" class="relative inline-flex h-2 w-2 rounded-full"></span>
        </span>

        <!-- Text with fixed minimum width to avoid layout jumping -->
        <p class="w-16 shrink-0 whitespace-nowrap text-left text-xs font-semibold sm:text-sm" x-text="statusText"></p>
    </div>

    <!-- Alpine Popover Teleport -->
    <template x-teleport="body">
        <div x-show="showPopover" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
            x-bind:class="dynamicBg
                ?
                'border-glass-border-light bg-glass-light backdrop-blur-md dark:border-glass-border-dark dark:bg-glass-dark' :
                'border-zinc-200 bg-white dark:border-zinc-800 dark:bg-dark-primary'"
            class="z-[110] w-64 rounded-xl border p-4 text-sm text-zinc-800 shadow-md dark:text-white dark:shadow-none"
            :style="popoverStyle" style="display: none;">
            <div class="flex flex-col gap-1">
                <p class="font-bold">Status Koneksi Database Central</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Silakan klik untuk memperbarui secara manual.
                    Pengecekan otomatis berjalan tiap 30 detik.</p>
            </div>
        </div>
    </template>
</div>
