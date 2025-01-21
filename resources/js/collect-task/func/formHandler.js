export function addDataHandler() {
  $('#store').click(function (e) {
    e.preventDefault(); // Jangan submit form

    const $button = $(this); // Tombol submit
    $button.prop('disabled', true); // Matikan tombol submit

    let formData = new FormData(); // FormData untuk mengirim file dan data
    formData.append("no_sr", $("#no_sr").val()); // Ambil value dari input dengan id no_sr
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
    formData.append("_token", $("meta[name='csrf-token']").attr("content")); // CSRF token

    // jika data sisa tagihan dari BSI dan Database tidak sama
    if ($('#remaining_bill').val() != $('#remaining_bill_bsi').val()) {
      $button.prop('disabled', false); // Hidupkan tombol submit
      Swal.fire('Sisa tagihan tidak sama.', 'Sisa tagihan dari Database dan BSI tidak sama. Silahkan hubungi IT untuk pengecekan data.', 'error');
      return;
    }

    axios.post(storeUrl, formData) // Kirim data ke server
      .then(function () { // Jika sukses
        Swal.fire({ // Tampilkan notifikasi sukses
          icon: "success",
          title: "Surat Jalan berhasil ditambahkan!",
          showConfirmButton: false,
          timer: 1000
        });
        setTimeout(() => window.location.reload(), 1000); // Reload halaman setelah 1 detik
      })
      .catch(function (error) { // Jika gagal
        if (error.response && error.response.data && error.response.data.errors) { // Jika ada error validasi
          handleFormErrors(error.response.data.errors); // Tampilkan error validasi
        }
        $button.prop('disabled', false); // Hidupkan tombol submit
      });
  });

  $('input, textarea, select').on('input change', function () { // Hapus pesan error saat input berubah
    const field = $(this).attr('id'); // Ambil id dari field
    const alertElement = document.getElementById(`alert-${field}`); // Cari element alert
    if (alertElement) { // Jika element alert ada
      alertElement.classList.add('hidden'); // Sembunyikan alert
      alertElement.innerHTML = ''; // Kosongkan isi alert
    }
  });
}

function handleFormErrors(errors) { // Tampilkan error validasi
  for (let field in errors) { // Loop semua error
    const alertElement = document.getElementById(`alert-${field}`); // Cari element alert
    if (alertElement) { // Jika element alert ada
      // Tampilkan pesan error hanya untuk field yang memiliki error
      alertElement.classList.remove('hidden'); // Tampilkan alert
      alertElement.innerHTML = errors[field][0]; // Tampilkan pesan error pertama
    }
  }
}