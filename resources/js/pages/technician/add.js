import { fetchDataHandler } from "./func/fetchData";
import { submitHandler } from "./func/submitHandler";

document.addEventListener('DOMContentLoaded', function () {
  fetchDataHandler();
  submitHandler();
})