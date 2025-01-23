import { showDatatables } from "./func/showData";
import { deleteData } from "./func/delete";
import { exportHandler } from "./func/exportLaporan";

$(document).ready(function () {
  showDatatables();
  deleteData();
  exportHandler();
})