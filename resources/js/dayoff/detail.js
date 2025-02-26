import { confirmAction } from "./func/validate";

document.addEventListener("livewire:navigated", function () {
  confirmAction();
})