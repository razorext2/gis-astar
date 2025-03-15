import { zoomImage } from "../../utils/zoomImage";
import { confirmAction } from "./func/validate";

document.addEventListener("livewire:navigated", function () {
  zoomImage();
  confirmAction();
})