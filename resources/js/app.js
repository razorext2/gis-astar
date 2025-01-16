import "./bootstrap";
import "flowbite";
import Swal from "sweetalert2";
import Quill from "quill";
import { handleNotification } from './notification';

// define userID, ambil dari metatag user-id
const userId = document.querySelector('meta[name="user-id"]').content;

// defina quill dan swal sebagai global variable  
window.Quill = Quill;
window.Swal = Swal;

// define Echo sebagai global variable
window.Echo.private(`notifications.${userId}`)
  .listen('.exportCompleted', (data) => {
    handleNotification(data);
  })
  .listen('.newTaskAssigned', (data) => {
    handleNotification(data);
  });
