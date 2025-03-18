import { addDataHandler } from "./func/formHandler";
import { searchDataHandler } from './func/searchHandler';
import { quillEditor } from '../../utils/quillEditor';
import { backCameraStream } from "../../utils/cameraStream";

document.addEventListener("DOMContentLoaded", function () {
  quillEditor();
  backCameraStream();
  searchDataHandler();
  addDataHandler();
})