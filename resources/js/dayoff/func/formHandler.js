export function addDataHandler() {
  $('#store').click(function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true); // Disable the button to prevent multiple clicks

    let formData = new FormData();
    formData.append("kode_pegawai", $("#kode_pegawai").val());
    formData.append("dayoff_for", $("#dayoff_for").val());
    formData.append("tgl_dari", $("#start-time").val());
    formData.append("tgl_hingga", $("#end-time").val());
    formData.append("keterangan", $("#keterangan").val());
    formData.append("_token", $("meta[name='csrf-token']").attr("content"));

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
          title: "Permohonan berhasil ditambahkan!",
          showConfirmButton: false,
          timer: 1000
        });
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/dayoff`, 1000);
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
        window.Swal.fire({
          icon: "success",
          title: "Permohonan berhasil diubah!",
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