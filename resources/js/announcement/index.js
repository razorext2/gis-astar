import { showDatatables } from "./func/showData";
import { addDataHandler, editDataHandler } from "./func/formHandler";
import { changeState } from "./func/changeState";
import { deleteData } from "./func/delete";

$(document).ready(function () {
  showDatatables();
  addDataHandler();
  editDataHandler();
  changeState();
  deleteData();
});