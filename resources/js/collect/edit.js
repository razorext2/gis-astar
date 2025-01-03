import { quillEditor } from "./func/quillEditor";
import { backCameraStream } from './func/cameraStream';
import { editDataHandler } from "./func/formHandler";
import { zoomImage } from "./func/zoomImage";
import { getLocation } from './func/geoLocation';

document.addEventListener("DOMContentLoaded", function () {
  quillEditor(data, true);
  backCameraStream();
  editDataHandler();
  zoomImage();
  getLocation();
})