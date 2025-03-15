import { confirmAction } from "./func/validate";
import { zoomImage } from "../../utils/zoomImage";

document.addEventListener("DOMContentLoaded", () => {
  zoomImage();
  confirmAction();
})