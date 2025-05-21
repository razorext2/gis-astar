import { fetchDataHandler } from "./func/fetchData";
import { backCameraStream } from "../../utils/cameraStream";
import { zoomImage } from "../../utils/zoomImage";
import { submitHandler } from "./func/submitHandler";

document.addEventListener('DOMContentLoaded', function () {
  fetchDataHandler();
  submitHandler();
  backCameraStream();
  zoomImage();
});