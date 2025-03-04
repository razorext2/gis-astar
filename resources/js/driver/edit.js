import { quillEditor } from "./func/quillEditor";
import { editDataHandler } from "./func/formHandler";
import { zoomImage } from "./func/zoomImage";

$(document).ready(function () {
  quillEditor(data, true);
  editDataHandler();
  zoomImage();
})