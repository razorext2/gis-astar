import { showDatatables } from "./func/showData";
import { deleteData } from "./func/delete";
import { singleAssign } from "./func/assign";
import { reschedule } from "./func/reschedule";

$(document).ready(function () {
  showDatatables();
  deleteData();
  singleAssign();
  reschedule();
})