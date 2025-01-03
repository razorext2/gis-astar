import { showDatatables } from "./func/showData";
import { deleteData } from "./func/delete";
import { singleAssign } from "./func/assign";

document.addEventListener("DOMContentLoaded", function () {
  showDatatables();
  deleteData();
  singleAssign();
})