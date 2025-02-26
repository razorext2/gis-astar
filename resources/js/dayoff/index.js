import { showDatatables } from "./func/showData";
import { deleteData } from "./func/delete";

document.addEventListener("livewire:navigated", function () {
  showDatatables();
  deleteData();
})