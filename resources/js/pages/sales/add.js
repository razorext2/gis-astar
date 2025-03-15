import { quillEditor } from "../../utils/quillEditor";
import { backCameraStream } from "../../utils/cameraStream";
import { addDataHandler } from "./func/formHandler";
import { getLocation } from '../../utils/geoLocation';

document.addEventListener("DOMContentLoaded", () => {
  quillEditor();
  backCameraStream();
  addDataHandler();
  getLocation();
});
