import { editDataHandler } from "./func/formHandler";
import { quillEditor } from "../../utils/quillEditor";

const data = document.getElementById('data').value;

document.addEventListener("DOMContentLoaded", function () {
  quillEditor(data, true);
  editDataHandler();
})