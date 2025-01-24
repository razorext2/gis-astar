import { capturedImages } from './cameraStream';

export function addDataHandler() {
  $('#store').click(function (e) {
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

    capturedImages.forEach((image, index) => {
      const blob = dataURItoBlob(image);
      formData.append("images[]", blob, `image${index}.png`);
    });

    axios.post(storeUrl, formData)
      .then(response => {
        Swal.fire({
          icon: "success",
          title: "Laporan berhasil ditambahkan!",
          showConfirmButton: false,
          timer: 1000
        });
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/sales`, 1000);
      })
      .catch(error => {
        handleFormErrors(error.response.data.errors);
        $button.prop('disabled', false);
      });
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
  for (let field in errors) {
    const alertElement = document.getElementById(`alert-${field}`);
    if (errors[field]) {
      alertElement.classList.remove('hidden');
      alertElement.classList.add('block');
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
