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

window.flatpickr = flatpickr;
window.$ = window.jQuery = $;
window.Swal = Swal;

const triggerPreloaderExit = () => {
    const preloader = document.getElementById('preloader');
    if (preloader && !preloader.classList.contains('preloader-exit')) {
        preloader.classList.add('preloader-exit');
        // Do NOT remove preloader from the DOM, allowing @persist('preloader')
        // to maintain its invisible, exited state across wire:navigate SPA routes.
        /*
        setTimeout(() => {
            if (preloader.parentNode) preloader.remove();
        }, 1500);
        */
    }
};

window.addEventListener('load', () => {
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
