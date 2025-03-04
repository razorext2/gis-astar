import { zoomImage } from "./func/zoomImage";
import { confirmAction } from "./func/validate";

$(document).ready(function () {
  zoomImage();
  confirmAction();
})