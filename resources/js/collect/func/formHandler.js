import { capturedImages } from './cameraStream'; // import capturedImages array

export function editDataHandler() {
  $('#store').click(async function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    // Ambil data form
    let formData = new FormData();
    let id = $('#id').val();

    formData.append("title", $("#title").val());
    formData.append("keterangan", $("#keterangan").val());
    formData.append("location", $("#location").val());
    formData.append("latitude", $("#latitude").val());
    formData.append("longitude", $("#longitude").val());
    formData.append("have_paid", $("#have_paid").val());
    formData.append("payment_type", $("#payment_type").val());
    formData.append("remaining_bill", $("#remaining_bill").val());
    formData.append("payment_amount", $("#payment_amount").val());
    formData.append('_method', 'PATCH');

    // Tambahkan gambar ke FormData
    for (const [index, image] of capturedImages.entries()) {
      const blob = await dataURItoBlob(image);
      formData.append("images[]", blob, `image${index}.png`);
    }

    try {
      const response = await axios.post(`${APP_URL}/api/collect-api/${id}`, formData);

      if (response.data.success) {
        Swal.fire({
          icon: "success",
          title: response.data.message,
          showConfirmButton: false,
          timer: 1500
        });
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect`, 1500);
      } else {
        handleFormErrors(response.data.data);
        Swal.fire({
          icon: "error",
          title: response.data.message,
          text: "Kamu harus mengisi semua form yang ada.",
          showConfirmButton: false,
          timer: 1500
        });
        $button.prop('disabled', false);
      }
    } catch (error) {
      console.error('Error:', error);
      Swal.fire({
        icon: "error",
        title: error.response?.data?.message || 'Terjadi kesalahan.',
        showConfirmButton: false,
        timer: 1500
      });
      $button.prop('disabled', false);
    }
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