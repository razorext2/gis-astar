import { zoomImage } from "../../utils/zoomImage";
import { fetchDataHandler } from "./func/fetchData";
import { submitHandler } from "./func/submitHandler";

document.addEventListener('DOMContentLoaded', function () {
  fetchDataHandler();
  submitHandler();
  zoomImage();

  document.getElementById('bast_document').addEventListener('change', function () {
    const file = this.files[0];
    const fileName = file.name;
    document.getElementById('documentName').textContent = fileName;
  });
});