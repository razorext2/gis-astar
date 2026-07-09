import $ from "jquery";
import "./bootstrap";
import "flowbite";
import Swal from "sweetalert2";
import flatpickr from "flatpickr";
import { initFlowbite } from "flowbite";
import { initEventListener } from "./utils/eventListener.js";
import { initWebSocketListener } from "./utils/webSocketListener";
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
import { zoomImage } from "./utils/zoomImage";
import "./components/dynamic-background.js";
import Lenis from "lenis";
import "lenis/dist/lenis.css";

import Quill from "quill";
import "quill/dist/quill.snow.css";

/** Goal: Clean up ApexCharts instances on Livewire 3 SPA navigation, Caller: Resources layouts, Deps: Livewire, livewire-charts */
document.addEventListener("livewire:init", () => {
    const chartCreators = [
        'livewireChartsAreaChart',
        'livewireChartsColumnChart',
        'livewireChartsLineChart',
        'livewireChartsMultiLineChart',
        'livewireChartsPieChart',
        'livewireChartsMultiColumnChart',
        'livewireChartsRadarChart',
        'livewireChartsTreeMapChart',
        'livewireChartsRadialChart'
    ];

    chartCreators.forEach(creatorName => {
        const originalCreator = window[creatorName];
        if (originalCreator) {
            window[creatorName] = function(...args) {
                const chartObj = originalCreator(...args);
                chartObj.destroy = function() {
                    if (this.chart) {
                        try {
                            this.chart.destroy();
                        } catch (e) {
                            console.warn("Failed to destroy chart:", e);
                        }
                    }
                };
                return chartObj;
            };
        }
    });
});

window.flatpickr = flatpickr;
window.$ = window.jQuery = $;

window.Swal = Swal;
window.Quill = Quill;

// Initialize Lenis dynamically based on sidebar state
let lenisInstance = null;

function initLenis() {
    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;
    if (prefersReducedMotion) return;

    if (!lenisInstance) {
        lenisInstance = new Lenis({
            lerp: 0.08,
            orientation: "vertical",
            gestureOrientation: "vertical",
            smoothWheel: true,
            autoRaf: true,
        });
        window.lenis = lenisInstance;
    }
}

function destroyLenis() {
    if (lenisInstance) {
        lenisInstance.destroy();
        lenisInstance = null;
        window.lenis = null;
    }
}

window.toggleLenis = function (shouldEnable) {
    if (shouldEnable) {
        initLenis();
    } else {
        destroyLenis();
    }
};

const triggerPreloaderExit = () => {
    const preloader = document.getElementById("preloader");
    if (preloader && !preloader.classList.contains("preloader-exit")) {
        preloader.classList.add("preloader-exit");
        // Do NOT remove preloader from the DOM, allowing @persist('preloader')
        // to maintain its invisible, exited state across wire:navigate SPA routes.
        /*
        setTimeout(() => {
            if (preloader.parentNode) preloader.remove();
        }, 1500);
        */
    }
};

window.addEventListener("load", () => {
    // Only trigger exit when the page finishes loading, immediately
    triggerPreloaderExit();
});

// Hard fallback (10s) just in case a network resource hangs the window.onload
setTimeout(triggerPreloaderExit, 10000);

Livewire.hook("commit", ({ component, commit, respond, succeed, fail }) => {
    succeed(({ snapshot, effect }) => {
        queueMicrotask(() => {
            initFlowbite();
        });
    });
});

document.addEventListener("livewire:navigated", function () {
    // For SPA navigation
    triggerPreloaderExit();
    initFlowbite();
    initEventListener();
    initWebSocketListener();

    // Optimize Lenis scroll positioning and recalculation
    if (window.lenis) {
        window.lenis.resize();
        if (window.location.hash) {
            const targetEl = document.querySelector(window.location.hash);
            if (targetEl) {
                window.lenis.scrollTo(targetEl, { immediate: true });
            }
        } else {
            window.lenis.scrollTo(0, { immediate: true });
        }
    }

    // handle other pages
    if (
        window.location.pathname === "/dashboard/attendanceIn" ||
        window.location.pathname === "/dashboard/attendanceOut"
    ) {
        zoomImage();
    } else if (window.location.pathname === "/dashboard/capture") {
        import("./pages/capture/index.js").then((module) => {
            module.initCapture();
        });
    } else if (window.location.pathname === "/dashboard/capture/route") {
        import("./pages/capture/route.js").then((module) => {
            module.initRecognition();
        });
    } else if (
        window.location.pathname.startsWith("/dashboard/collect-idy-ppn")
    ) {
        import("./pages/collect-idy-ppn/index.js").then((module) => {
            module.initCollectIdyPpn();
        });
    } else if (
        window.location.pathname.startsWith("/dashboard/collect-task-ppn")
    ) {
        import("./pages/collect-task-ppn/index.js").then((module) => {
            module.initCollectTaskPpn();
        });
    } else if (window.location.pathname.startsWith("/dashboard/collect-task")) {
        import("./pages/collect-task/index.js").then((module) => {
            module.initCollectTask();
        });
    } else if (window.location.pathname.startsWith("/dashboard/collect")) {
        import("./pages/collect/index.js").then((module) => {
            module.initCollect();
        });
    }
});
