import { addDataHandler } from "./func/formHandler";
import { quillEditor } from './func/quillText';
import { searchDataHandler } from './func/searchHandler';

document.addEventListener("DOMContentLoaded", function () {
  addDataHandler();
  quillEditor();
  searchDataHandler();
})