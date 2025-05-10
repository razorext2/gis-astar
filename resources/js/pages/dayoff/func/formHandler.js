import { capturedImages } from "../../../utils/cameraStream";
import { showAlert, loadingAlert } from "../../../utils/alert";

export function addDataHandler() {
  $('#store').click(async function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true); // Disable the button to prevent multiple clicks

    loadingAlert("Menyimpan data...");

    let formData = new FormData();

    formData.append("kode_pegawai", $("#kode_pegawai").val());
    formData.append("dayoff_for", $("#dayoff_for").val());
    formData.append("tgl_dari", $("#start-time").val());
    formData.append("tgl_hingga", $("#end-time").val());
    formData.append("keterangan", $("#keterangan").val());

    for (const [index, image] of capturedImages.entries()) {
      const blob = await dataURItoBlob(image);
      formData.append("images[]", blob, `image${index}.png`);
    }

    try {
      const response = await axios.post(`${APP_URL}/api/dayoff-api`, formData);

      if (response.data.success) {
        Swal.close();
        showAlert('success', response.data.message);
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/dayoff`, 1500);
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
      $button.prop('disabled', false);
      Swal.close();
      return showAlert('error', 'Terjadi kesalahan.', error.message);
    }
  });
}

export function editDataHandler() {
  $('#store').click(function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    // define var
    let id = $('#id').val();
    let dayoff_for = $("#dayoff_for").val();
    let tgl_dari = $("#tgl_dari").val();
    let tgl_hingga = $("#tgl_hingga").val();
    let keterangan = $("#keterangan").val();
    let token = $("meta[name='csrf-token']").attr("content");

    // ajax request
    $.ajax({
      url: `${APP_URL}/api/dayoff-api/${id}`,
      type: "PATCH",
      dataType: "json",
      data: {
        "dayoff_for": dayoff_for,
        "tgl_dari": tgl_dari,
        "tgl_hingga": tgl_hingga,
        "keterangan": keterangan,
        "_token": token
      },
      success: function () {
        // tampilkan alert
        showAlert('success', 'Permohonan berhasil diubah!');
        setTimeout(() => window.location.reload(), 1000);
      },
      error: function (xhr) {
        handleFormErrors(xhr.responseJSON.errors);
        $button.prop('disabled', false);
      }
    });
  });
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