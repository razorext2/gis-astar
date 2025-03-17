import $ from "jquery";
import "./bootstrap";
import "flowbite";
import Swal from "sweetalert2";
import flatpickr from "flatpickr";
import { fetchNotification } from './utils/notificationListener';
import { initEventListener } from './utils/eventListener.js';
import { initWebSocketListener } from './utils/webSocketListener';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';

window.flatpickr = flatpickr;
window.$ = window.jQuery = $;
window.Swal = Swal;

document.addEventListener('livewire:navigated', function () {
  fetchNotification();
  initEventListener();
  initWebSocketListener();

  // handle announcement
  if (window.location.pathname === '/dashboard/announcement') {
    import('./pages/announcement/index.js').then((module) => {
      module.initAnnouncement();
    })
  } else if (window.location.pathname === '/dashboard/sales') {
    import('./pages/sales/index.js').then((module) => {
      module.initSales();
    })
  } else if (window.location.pathname === '/dashboard/technician') {
    import('./pages/technician/index.js').then((module) => {
      module.initTechnician();
    })
  } else if (window.location.pathname === '/dashboard/capture') {
    import('./pages/capture/index.js').then((module) => {
      module.initCapture();
    });
    import('./pages/capture/selfDetect.js').then((module) => {
      module.initSelfDetect();
    });
  } else if (window.location.pathname === '/dashboard/dayoff') {
    import('./pages/dayoff/index.js').then((module) => {
      module.initDayoff();
    });
  } else if (window.location.pathname.startsWith('/dashboard/collect-idy-ppn')) {
    import('./pages/collect-idy-ppn/index.js').then((module) => {
      module.initCollectIdyPpn();
    });
  } else if (window.location.pathname.startsWith('/dashboard/collect-task-ppn')) {
    import('./pages/collect-task-ppn/index.js').then((module) => {
      module.initCollectTaskPpn();
    });
  }
  else if (window.location.pathname.startsWith('/dashboard/collect-task')) {
    import('./pages/collect-task/index.js').then((module) => {
      module.initCollectTask();
    });
  } else if (window.location.pathname.startsWith('/dashboard/collect')) {
    import('./pages/collect/index.js').then((module) => {
      module.initCollect();
    });
  }
});