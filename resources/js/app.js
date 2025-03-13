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
  }

});