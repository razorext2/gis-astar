import { editDataHandler } from "./func/formHandler";
import { quillEditor } from "../../utils/quillEditor";
import { zoomImage } from "../../utils/zoomImage";

const data = document.getElementById('data').value;

document.addEventListener("DOMContentLoaded", () => {
  quillEditor(data, true);
  editDataHandler();
  zoomImage();
})