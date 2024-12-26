import { quillEditor } from './func/quillEditor';
import { backCameraStream } from './func/cameraStream';
import { addDataHandler } from './func/formHandler';
import { getLocation } from './func/geoLocation';

document.addEventListener("DOMContentLoaded", function () {
  quillEditor();
  backCameraStream();
  getLocation();
  addDataHandler();
});
