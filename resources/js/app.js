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

import Quill from "quill";
import "quill/dist/quill.snow.css";

/** Goal: Clean up ApexCharts instances on Livewire 3 SPA navigation, Caller: Resources layouts, Deps: Livewire, livewire-charts */
document.addEventListener("livewire:init", () => {
    const chartCreators = [
        "livewireChartsAreaChart",
        "livewireChartsColumnChart",
        "livewireChartsLineChart",
        "livewireChartsMultiLineChart",
        "livewireChartsPieChart",
        "livewireChartsMultiColumnChart",
        "livewireChartsRadarChart",
        "livewireChartsTreeMapChart",
        "livewireChartsRadialChart",
    ];

    chartCreators.forEach((creatorName) => {
        const originalCreator = window[creatorName];
        if (originalCreator) {
            window[creatorName] = function (...args) {
                const chartObj = originalCreator(...args);
                chartObj.destroy = function () {
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

    // Register zoom globally — safe to call every navigation because
    // zoomImage uses a stable named handler reference (no duplicates).
    zoomImage();

    const path = window.location.pathname;

    // handle other pages
    if (path === "/dashboard/capture") {
        import("./pages/capture/index.js").then((module) => {
            module.initCapture();
        });
    } else if (path === "/dashboard/capture/route") {
        import("./pages/capture/route.js").then((module) => {
            module.initRecognition();
        });
    } else if (path.startsWith("/dashboard/collect-idy-ppn")) {
        import("./pages/collect-idy-ppn/index.js").then((module) => {
            module.initCollectIdyPpn();
        });
    } else if (path.startsWith("/dashboard/collect-task-ppn")) {
        import("./pages/collect-task-ppn/index.js").then((module) => {
            module.initCollectTaskPpn();
        });
    } else if (path.startsWith("/dashboard/collect-task")) {
        import("./pages/collect-task/index.js").then((module) => {
            module.initCollectTask();
        });
    } else if (path.startsWith("/dashboard/collect")) {
        import("./pages/collect/index.js").then((module) => {
            module.initCollect();
        });
    }
});
