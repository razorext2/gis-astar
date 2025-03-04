import { deleteData } from "./func/delete";
import { confirmModal } from "./func/confirmModal";

document.addEventListener('livewire:navigated', function () {
  deleteData();
  confirmModal();
})

