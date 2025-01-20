import { quillEditor } from "./func/quillEditor";
import { backCameraStream } from "./func/cameraStream";
import { addDataHandler } from "./func/formHandler";
import { getLocation } from './func/geoLocation';

$(document).ready(function () {
  quillEditor();
  backCameraStream();
  addDataHandler();
  getLocation();
});
