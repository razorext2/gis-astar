import { editDataHandler } from "./func/formHandler";
import { quillEditor } from "../../utils/quillEditor";
import { backCameraStream, resetCapturedImages } from '../../utils/cameraStream';
import { zoomImage } from "../../utils/zoomImage";
import { getLocation } from '../../utils/geoLocation';
import { loadingAlert, showAlert } from '../../utils/alert';

const data = document.getElementById('data') ? document.getElementById('data').value : ''; // Validasi elemen 'data'

document.addEventListener("DOMContentLoaded", async () => {
  // Menangani perubahan status pembayaran
  document.getElementById('have_paid').addEventListener('change', function () {
    const have_paid = $(this).val();
    const have_paid_container = $('#have_paid_container');
    const payment_amount_container = $('#payment_amount_container');
    const payment_type_container = $('#payment_type_container');
    const payment_amount = $('#payment_amount');
    const payment_type = $('#payment_type');
    const no_giro_container = $('#no_giro_container');

    if (have_paid != 1 && have_paid != 2) {
      have_paid_container.removeClass('lg:col-span-1 ');
      payment_amount_container.addClass('hidden');
      payment_type_container.addClass('hidden');
      no_giro_container.addClass('hidden');

      payment_amount.val('0');
      payment_type.val('0');
      $('#no_giro').val('0');
    } else {
      have_paid_container.addClass('lg:col-span-1 ');
      payment_amount_container.removeClass('hidden');
      payment_type_container.removeClass('hidden');
    }
  });

  // Menangani jenis pembayaran
  $('#payment_type').on('change', function () {
    const payment_type = $(this).val();
    const no_giro_container = $('#no_giro_container');

    if (payment_type == 3) {
      no_giro_container.removeClass('hidden');
    } else {
      no_giro_container.addClass('hidden');
      $('#no_giro').val('0');
    }
  });

  // Inisialisasi editor Quill
  quillEditor(data, true);
  // Inisialisasi kamera belakang
  resetCapturedImages();
  backCameraStream();
  // Inisialisasi handler data
  editDataHandler();
  // Inisialisasi zoom gambar
  zoomImage();

  try {
    // Tampilkan Swal loading saat proses pengambilan lokasi
    loadingAlert("Mengambil lokasi...");

    // Ambil lokasi secara asinkron
    const coords = await getLocation('collect');

    // Isi form dengan lokasi yang diperoleh
    $('#longitude').val(coords.longitude);
    $('#latitude').val(coords.latitude);
    console.log("Lokasi didapat dari:", coords.from);

    // Tutup Swal loading setelah selesai
    Swal.close();
  } catch (err) {
    // Jika terjadi error, tutup Swal dan tampilkan pesan error
    Swal.close();
    showAlert('error', 'Gagal mengambil lokasi', err.message);
  }
});
