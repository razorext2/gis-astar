import { deleteData } from "./func/delete";
import { confirmModal } from "./func/confirmModal";

document.addEventListener('DOMContentLoaded', function () {
  confirmModal();
})

document.addEventListener('livewire:navigated', function () {
  console.log("Livewire navigated, reloading script!");
  deleteData();
  confirmModal();
})

