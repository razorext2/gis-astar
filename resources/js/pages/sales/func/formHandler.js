import { capturedImages } from '../../../utils/cameraStream';
import { showAlert, loadingAlert } from "../../../utils/alert";
import Swal from 'sweetalert2';

export function addDataHandler() {
  $('#store').on('click', async function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    loadingAlert("Menyimpan...");

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
      const response = await axios.post(`/api/sales-api`, formData);

      if (response.data.success) {
        Swal.close();
        showAlert('success', response.data.message);
        setTimeout(() => window.location.href = `/dashboard/sales`, 1500);
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

    loadingAlert("Menyimpan...");

    // define variable
    let id = $('#id').val();
    let title = $("#title").val();
    let customer_name = $("#customer_name").val();
    let customer_telp = $("#customer_telp").val();
    let lokasi = $('#lokasi').val();
    let keterangan = $("#keterangan").val();

    // axios request
    axios.patch(`/api/sales-api/${id}`, {
      id: id,
      title: title,
      customer_name: customer_name,
      customer_telp: customer_telp,
      lokasi: lokasi,
      keterangan: keterangan,
    })
      .then(response => {
        Swal.close();
        showAlert('success', response.data.message);
        setTimeout(() => window.location.href = `/dashboard/sales`, 1500);
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
