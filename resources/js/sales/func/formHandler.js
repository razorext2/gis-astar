import { capturedImages } from './cameraStream';
import { showAlert } from "../../utils/alert";

export function addDataHandler() {
  $('#store').click(async function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    let formData = new FormData();

    formData.append("kode_pegawai", $("#kode_pegawai").val());
    formData.append("title", $("#title").val());
    formData.append("customer_name", $("#customer_name").val());
    formData.append("customer_telp", $("#customer_telp").val());
    formData.append("keterangan", $("#keterangan").val());
    formData.append("lokasi", $("#lokasi").val());
    formData.append("latitude", $("#latitude").val());
    formData.append("longitude", $("#longitude").val());

    for (const [index, image] of capturedImages.entries()) {
      const blob = await dataURItoBlob(image);
      formData.append("images[]", blob, `image${index}.png`);
    }

    try {
      const response = await axios.post(`${APP_URL}/api/sales-api`, formData);

      if (response.data.success) {
        showAlert('success', response.data.message);
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/sales`, 1500);
      } else {
        handleFormErrors(response.data.data);
        showAlert('error', response.data.message, 'Kamu harus mengisi semua form yang ada.');
        $button.prop('disabled', false);
      }
    } catch (error) {
      console.error('Error:', error);
      showAlert('error', 'Terjadi kesalahan.', error.message);
      $button.prop('disabled', false);
    }

  });
}

export function editDataHandler() {
  $('#store').click(function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    // define variable
    let id = $('#id').val();
    let title = $("#title").val();
    let customer_name = $("#customer_name").val();
    let customer_telp = $("#customer_telp").val();
    let lokasi = $('#lokasi').val();
    let keterangan = $("#keterangan").val();

    // axios request
    axios.patch(`${APP_URL}/api/sales-api/${id}`, {
      id: id,
      title: title,
      customer_name: customer_name,
      customer_telp: customer_telp,
      lokasi: lokasi,
      keterangan: keterangan,
    })
      .then(response => {
        Swal.fire({
          icon: "success",
          title: "Laporan berhasil diubah!",
          showConfirmButton: false,
          timer: 1000
        });
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/sales`, 1000);
      })
      .catch(error => {
        handleFormErrors(error.response.data.errors);
        $button.prop('disabled', false);
      });
  })
}

function handleFormErrors(errors) {
  if (typeof errors === 'object') {
    $.each(errors, function (field, errorMessages) {
      var $alertElement = $(`#alert-${field}`);
      if (errorMessages && errorMessages.length) {
        $alertElement.removeClass('hidden').html(errorMessages[0]);
      } else {
        $alertElement.removeClass('block').addClass('hidden');
      }
    });
  }
}

async function dataURItoBlob(dataURI) {
  const response = await axios.get(dataURI, { responseType: 'blob' });
  return response.data;
}
