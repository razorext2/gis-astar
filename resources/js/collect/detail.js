import { zoomImage } from "./func/zoomImage";
import { confirmAction } from "./func/validate";

document.addEventListener("livewire:navigated", function () {
  zoomImage();
  confirmAction();
})