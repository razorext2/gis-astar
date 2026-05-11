import { zoomImage } from "../../utils/zoomImage";

document.addEventListener("livewire:navigated", function () {
  zoomImage();
});
