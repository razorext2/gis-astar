import { addDataHandler } from "./func/formHandler";
import { quillEditor } from "../../utils/quillEditor";
import { backCameraStream, resetCapturedImages } from "../../utils/cameraStream";
import { getLocation } from '../../utils/geoLocation';

document.addEventListener("DOMContentLoaded", async () => {
  // Inisialisasi kamera belakang
  resetCapturedImages();
  backCameraStream();
  // Inisialisasi handler data
  addDataHandler();

  try {
    // Tampilkan Swal loading saat proses pengambilan lokasi
    window.Swal.fire({
      title: "Mengambil lokasi...",
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => window.Swal.showLoading()
    });

    // Ambil lokasi secara asinkron
    const coords = await getLocation('driver');

    // Isi form dengan lokasi yang diperoleh
    $('#longitude').val(coords.longitude);
    $('#latitude').val(coords.latitude);
    console.log("Lokasi didapat dari:", coords.from);

    // Tutup Swal loading setelah selesai
    window.Swal.close();
  } catch (err) {
    // Jika terjadi error, tutup Swal dan tampilkan pesan error
    window.Swal.close();
    window.Swal.fire({
      title: "Gagal",
      html: err.message,
      icon: "error",
      showConfirmButton: true
    });
  }
});
