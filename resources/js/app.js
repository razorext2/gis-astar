import "./bootstrap";
import "flowbite";
import Swal from "sweetalert2";
import { handleNotification, handleAnnouncement, fetchNotification } from './notification';

$(document).ready(function () {

  fetchNotification();

  // define userID, ambil dari metatag user-id
  const userId = document.querySelector('meta[name="user-id"]');

  // define swal sebagai global variable  
  window.Swal = Swal;

  if (userId) {
    // define Echo sebagai global variable
    window.Echo.private(`notifications.${userId.content}`)
      .listen('.exportCompleted', (data) => {
        handleNotification(data);
      })
      .listen('.newTaskAssigned', (data) => {
        handleNotification(data);
      })
      .listen('.collectorUpdatedReport', (data) => {
        handleNotification(data);
      })
      .listen('.salesNewReport', (data) => {
        handleNotification(data);
      });

    window.Echo.private(`announcements.${userId.content}`)
      .listen('.newAnnouncement', (data) => {
        console.log(data);
        handleAnnouncement(data);
      });
  }
});
