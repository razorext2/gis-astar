import { quillEditor } from "../../utils/quillEditor";
import { backCameraStream, resetCapturedImages } from "../../utils/cameraStream";
import { addDataHandler } from "./func/formHandler";
import { getLocation } from '../../utils/geoLocation';
import { loadingAlert, showAlert } from "../../utils/alert";

document.addEventListener("DOMContentLoaded", async () => {
  // Inisialisasi editor Quill
  quillEditor();
  // Inisialisasi kamera belakang
  resetCapturedImages();
  backCameraStream();
  // Inisialisasi handler data
  addDataHandler();

  try {
    // Tampilkan Swal loading saat proses pengambilan lokasi
    loadingAlert("Mengambil lokasi...");

    // Ambil lokasi secara asinkron
    const coords = await getLocation('driver');

    // Isi form dengan lokasi yang diperoleh
    $('#longitude').val(coords.longitude);
    $('#latitude').val(coords.latitude);
    console.log("Lokasi didapat dari:", coords.from);

    // Tutup Swal loading setelah selesai
    Swal.close();
  } catch (err) {
    // Jika terjadi error, tutup Swal dan tampilkan pesan error
    Swal.close();
    showAlert('error', 'Terjadi kesalahan.', err.message);
  }
});
