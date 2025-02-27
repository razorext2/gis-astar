import { addDataHandler, editDataHandler } from "./func/formHandler";
import { changeState } from "./func/changeState";
import { deleteData } from "./func/delete";

document.addEventListener('livewire:navigated', function () {
  addDataHandler();
  editDataHandler();
  changeState();
  deleteData();
});