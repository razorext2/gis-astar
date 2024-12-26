import { capturedImages } from './cameraStream'; // import capturedImages array

export function addDataHandler() {
  $('#store').click(function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true); // Disable the button to prevent multiple clicks

    let formData = new FormData();
    formData.append("kode_pegawai", $("#kode_pegawai").val());
    formData.append("title", $("#title").val());
    formData.append("keterangan", $("#keterangan").val());
    formData.append("longitude", $("#longitude").val());
    formData.append("latitude", $("#latitude").val());
    formData.append("location", $("#location").val());
    formData.append("_token", $("meta[name='csrf-token']").attr("content"));

    capturedImages.forEach((image, index) => {
      const blob = dataURItoBlob(image);
      formData.append("images[]", blob, `image${index}.png`);
    });

    $.ajax({
      url: storeUrl,
      type: "POST",
      dataType: "json",
      data: formData,
      processData: false,
      contentType: false,
      success: function () {
        Swal.fire({
          icon: "success",
          title: "Laporan berhasil ditambahkan!",
          showConfirmButton: false,
          timer: 1000
        });
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect`, 1000);
      },
      error: function (xhr) {
        handleFormErrors(xhr.responseJSON.errors);
        $button.prop('disabled', false); // Use the stored button reference
      }
    });
  });
}

export function editDataHandler() {
  $('#store').click(function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    // define var
    let id = $('#id').val();
    let judul = $("#title").val();
    let ket = $("#keterangan").val();
    let location = $("#location").val();
    let token = $("meta[name='csrf-token']").attr("content");

    // ajax request
    $.ajax({
      url: `${APP_URL}/api/collect-api/${id}`,
      type: "PATCH",
      dataType: "json",
      data: {
        "title": judul,
        "keterangan": ket,
        "location": location,
        "_token": token
      },
      success: function () {
        // tampilkan alert
        window.Swal.fire({
          icon: "success",
          title: "Laporan berhasil diubah!",
          showConfirmButton: false,
          timer: 1000
        });

        setTimeout(() => window.location.reload(), 1000);
      },
      error: function (xhr) {
        handleFormErrors(xhr.responseJSON.errors);
        $button.prop('disabled', false); // Use the stored button reference
      }
    });
  });
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