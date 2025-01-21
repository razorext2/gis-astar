import { capturedImages } from './cameraStream'; // import capturedImages array

export function editDataHandler() {
  $('#store').click(function (e) {
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
    formData.append("_token", $("meta[name='csrf-token']").attr("content"));
    formData.append('_method', 'PATCH');

    // Tambahkan gambar ke FormData
    capturedImages.forEach((image, index) => {
      const blob = dataURItoBlob(image);
      formData.append("images[]", blob, `image${index}.png`);
    });

    // Permintaan AJAX
    axios.post(`${APP_URL}/api/collect-api/${id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then(() => {
        Swal.fire({
          icon: "success",
          title: "Laporan berhasil diubah!",
          showConfirmButton: false,
          timer: 1000
        });
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect`, 1000);
      })
      .catch((error) => {
        if (error.response && typeof handleFormErrors === "function") {
          handleFormErrors(error.response.data);
        } else {
          console.error(error.response ? error.response.data : error);
        }
        $button.prop('disabled', false); // Aktifkan tombol kembali
      });
  });

}

function handleFormErrors(errors) {
  for (let field in errors) {
    const alertElement = document.getElementById(`alert-${field}`);
    if (errors[field]) {
      alertElement.classList.remove('hidden');
      alertElement.innerHTML = errors[field][0];
    } else {
      alertElement.classList.remove('block');
      alertElement.classList.add('hidden');
    }
  }
}

function dataURItoBlob(dataURI) {
  const byteString = atob(dataURI.split(',')[1]);
  const arrayBuffer = new ArrayBuffer(byteString.length);
  const uintArray = new Uint8Array(arrayBuffer);
  for (let i = 0; i < byteString.length; i++) {
    uintArray[i] = byteString.charCodeAt(i);
  }
  return new Blob([uintArray], { type: 'image/png' });
}