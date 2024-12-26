import { addDataHandler } from "./func/formHandler";
import { quillEditor } from './func/quillEditor';
import { searchDataHandler } from './func/searchHandler';

document.addEventListener("DOMContentLoaded", function () {
  quillEditor();
  searchDataHandler();
  addDataHandler();
})