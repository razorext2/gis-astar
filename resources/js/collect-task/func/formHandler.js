export function addDataHandler() {
  $('#store').click(function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true); // Disable the button to prevent multiple clicks

    let formData = new FormData();
    formData.append("no_sr", $("#no_sr").val());
    formData.append("sr_type", $("#sr_type").val());
    formData.append("sr_date", $("#sr_date").val());
    formData.append("customer_name", $("#customer_name").val());
    formData.append("customer_recipient", $("#customer_recipient").val());
    formData.append("customer_address", $("#customer_address").val());
    formData.append("customer_telp", $("#customer_telp").val());
    formData.append("customer_fax", $("#customer_fax").val());
    formData.append("shipping_address", $("#shipping_address").val());
    formData.append("total_bill", $("#total_bill").val());
    formData.append("remaining_bill", $("#remaining_bill").val());
    formData.append("assign_by", $("#assign_by").val());
    formData.append("assign_to", $("#assign_to").val());
    formData.append("assign_date", $("#assign_date").val());
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
          title: "Surat Jalan berhasil ditambahkan!",
          showConfirmButton: false,
          timer: 1000
        });
        setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect-task`, 1000);
      },
      error: function (xhr) {
        handleFormErrors(xhr.responseJSON.errors);
        $button.prop('disabled', false);
      }
    });
  });

  $('input, textarea, select').on('input change', function () {
    const field = $(this).attr('id');
    const alertElement = document.getElementById(`alert-${field}`);
    if (alertElement) {
      alertElement.classList.add('hidden');
      alertElement.innerHTML = '';
    }
  });
}

function handleFormErrors(errors) {
  for (let field in errors) {
    const alertElement = document.getElementById(`alert-${field}`);
    if (alertElement) {
      // Tampilkan pesan error hanya untuk field yang memiliki error
      alertElement.classList.remove('hidden');
      alertElement.innerHTML = errors[field][0];
    }
  }
}