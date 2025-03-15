import { quillEditor } from "../../utils/quillEditor";
import { zoomImage } from "../../utils/zoomImage";
import { editDataHandler } from "./func/formHandler";

document.addEventListener("DOMContentLoaded", () => {
  quillEditor(data, true);
  editDataHandler();
  zoomImage();
})