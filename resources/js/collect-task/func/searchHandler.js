export function searchDataHandler() {
  let debounceTimer;
  $('#no_sr_submit').on('click', function () {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(() => {
      let no_sr = $('#no_sr').val();
      $.ajax({
        url: `/proxy/fetchSR`,
        type: "GET",
        data: { NomorPermintaanJual: no_sr },
        success: function (response) {
          if (response && response.data) {
            $('#sr_date').val(response.data[0].TanggalPermintaanJual.date);
            $('#customer_name').val(response.data[0].NamaCustomer);
            $('#customer_recipient').val(response.data[0].CustomerContact);
            $('#customer_address').val(response.data[0].AlamatContact);
            $('#customer_telp').val(response.data[0].TeleponContact);
            $('#customer_fax').val(response.data[0].FaxContact);
            $('#shipping_address').val(response.data[0].AlamatKirim);
            $('#total_bill').val(response.data[0].Total);
          } else {
            Swal.fire({
              icon: "error",
              title: "No SR tidak ditemukan!",
              showConfirmButton: false,
              timer: 1000,
            });
            clear();
          }
        },
      });
    }, 300);
  });
}

function clear() {
  $('#no_sr').val('');
  $('#sr_date').val('');
  $('#customer_name').val('');
  $('#customer_recipient').val('');
  $('#customer_address').val('');
  $('#customer_telp').val('');
  $('#customer_fax').val('');
  $('#shipping_address').val('');
  $('#total_bill').val('');
}

$('#no_sr_reset').on('click', function () {
  clear();
})