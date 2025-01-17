import { showDatatables } from "./func/showData";
import { deleteData } from "./func/delete";
import { exportHandler } from "./func/exportLaporan";

document.addEventListener("DOMContentLoaded", function () {
  showDatatables();
  deleteData();
  exportHandler();
})