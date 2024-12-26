import { quillEditor } from "./func/quillEditor";
import { editDataHandler } from "./func/formHandler";

document.addEventListener("DOMContentLoaded", function () {
  quillEditor(data, true);
  editDataHandler();
})