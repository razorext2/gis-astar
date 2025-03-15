import { addDataHandler } from "./func/formHandler";
import { searchDataHandler } from './func/searchHandler';

document.addEventListener("DOMContentLoaded", function () {
  searchDataHandler();
  addDataHandler();
});
