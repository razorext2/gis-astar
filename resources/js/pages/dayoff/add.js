import { addDataHandler } from "./func/formHandler";
import { searchDataHandler } from './func/searchHandler';
import { quillEditor } from '../../utils/quillEditor';

document.addEventListener("DOMContentLoaded", function () {
  quillEditor();
  searchDataHandler();
  addDataHandler();
})