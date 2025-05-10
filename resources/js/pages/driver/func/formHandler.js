import { capturedImages } from '../../../utils/cameraStream';
import { showAlert, loadingAlert } from '../../../utils/alert';

export function addDataHandler() {
  $('#store').click(async function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    loadingAlert("Menyimpan data...");

    let formData = new FormData();

    formData.append("kode_pegawai", $("#kode_pegawai").val());
    formData.append("title", $("#title").val());
    formData.append("keterangan", $("#keterangan").val());
    formData.append("lokasi", $("#lokasi").val());
    formData.append("latitude", $("#latitude").val());
    formData.append("longitude", $("#longitude").val());

    for (const [index, image] of capturedImages.entries()) {
      const blob = await dataURItoBlob(image);
      formData.append("images[]", blob, `image${index}.png`);
    }

    try {
      const response = await axios.post(`${APP_URL}/api/driver-api`, formData);

      if (response.data.success) {
        Swal.close();
        showAlert('success', response.data.message);
        setTimeout(() => Livewire.navigate(`${APP_URL}/dashboard/driver`), 1000);
      } else {
        Swal.close();
        $button.prop('disabled', false);
        handleFormErrors(response.data.data);
        let err = null;
        let data = response.data.data;

        if (typeof data === 'object' && data !== null) {
          let firstKey = Object.keys(data)[0];
          if (firstKey && Array.isArray(data[firstKey])) {
            err = data[firstKey][0]; // Ambil elemen pertama dari array dalam objek
          }
        } else {
          err = data;
        }
        return showAlert('error', response.data.message, `Validasi data gagal. <br><b>${err}</b>`);
      }
    } catch (error) {
      Swal.close();
      $button.prop('disabled', false);
      console.error('Error:', error);
      return showAlert('error', 'Terjadi kesalahan.', error.message);
    }
  });
}

export function editDataHandler() {
  $('#store').click(function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    loadingAlert("Menyimpan data...");

    // define variable
    let id = $('#id').val();
    let title = $("#title").val();
    let lokasi = $('#lokasi').val();
    let keterangan = $("#keterangan").val();

    // axios request
    axios.patch(`${APP_URL}/api/driver-api/${id}`, {
      id: id,
      title: title,
      lokasi: lokasi,
      keterangan: keterangan,
    })
      .then(response => {
        Swal.close();
        showAlert('success', 'Laporan berhasil diubah!');
        setTimeout(() => Livewire.navigate(`${APP_URL}/dashboard/driver`), 1000);
      })
      .catch(error => {
        Swal.close();
        $button.prop('disabled', false);
        handleFormErrors(error.response.data.errors);
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
