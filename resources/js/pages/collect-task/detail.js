import { validate } from "./func/validate";

document.addEventListener("livewire:navigated", function () {
  validate();
})