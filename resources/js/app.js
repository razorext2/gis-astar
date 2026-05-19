/** Goal: Main App Entry point & Lenis smooth scroll orchestration, Caller: Blade Layouts, Deps: Lenis, Flowbite, Livewire */
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

import Lenis from "lenis";
import "lenis/dist/lenis.css";

window.flatpickr = flatpickr;
window.$ = window.jQuery = $;
window.Swal = Swal;

// Initialize Lenis — https://github.com/darkroomengineering/lenis
const lenis = new Lenis({
    autoRaf: true,
    anchors: true,
    lerp: 0.06, // Smooth inertia — lower = silkier, less overshoot
});

window.lenis = lenis;

let _lenisResizeTimer;
Livewire.hook("commit", ({ component, commit, respond, succeed, fail }) => {
    succeed(({ snapshot, effect }) => {
        queueMicrotask(() => {
            initFlowbite();
            // Debounce resize and skip if Lenis is actively scrolling to prevent jitter
            if (window.lenis && !window.lenis.isScrolling) {
                clearTimeout(_lenisResizeTimer);
                _lenisResizeTimer = setTimeout(() => {
                    if (window.lenis && !window.lenis.isScrolling) {
                        window.lenis.resize();
                    }
                }, 200);
            }
        });
    });
});

document.addEventListener("livewire:navigated", function () {
    if (window.lenis) {
        window.lenis.resize();
    }
    initFlowbite();
    initEventListener();
    initWebSocketListener();

    // handle announcement
    if (window.location.pathname === "/dashboard/announcement") {
        import("./pages/announcement/index.js").then((module) => {
            module.initAnnouncement();
        });
    } else if (window.location.pathname === "/dashboard/sales") {
        import("./pages/sales/index.js").then((module) => {
            module.initSales();
        });
    } else if (
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
