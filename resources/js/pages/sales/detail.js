import { zoomImage } from "../../utils/zoomImage";
import { confirmAction } from "./func/validate";

document.addEventListener("DOMContentLoaded", () => {
  zoomImage();
  confirmAction();
})