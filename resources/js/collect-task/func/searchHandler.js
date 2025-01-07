export function searchDataHandler() {
  let debounceTimer;
  $('#no_sr_submit').on('click', function () {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(async () => {
      let no_sr = $('#no_sr').val();

      // Cari data SR di API BSI
      try {
        const responseBSI = await axios.get(`${APP_URL}/proxy/fetchSR`, {
          params: { NomorPermintaanJual: no_sr }
        });

        if (responseBSI.data && responseBSI.data.data) {
          const data = responseBSI.data.data[0];
          $('#sr_date').val(data.TanggalPermintaanJual.date);
          $('#customer_name').val(data.NamaCustomer);
          $('#customer_recipient').val(data.CustomerContact);
          $('#customer_address').val(data.AlamatContact);
          $('#customer_telp').val(data.TeleponContact);
          $('#customer_fax').val(data.FaxContact);
          $('#shipping_address').val(data.AlamatKirim);

          // Cari data SR di database
          try {
            const responseDB = await axios.get(`${APP_URL}/api/collect-task-api/getSR/${no_sr}`);

            if (responseDB.data && responseDB.data.data) {
              // console.log('dari db')
              $('#remaining_bill').val(responseBSI.data.data[0].Total);
              $('#total_bill').val(responseDB.data.data.total_bill);
            } else {
              // console.log('dari bsi')
              $('#remaining_bill').val(responseBSI.data.data[0].Total);
              $('#total_bill').val(responseBSI.data.data[0].Total);
            }
          } catch (error) {
            console.error("Error fetching data from database:", error);
            Swal.fire({
              icon: "error",
              title: error.message || "Terjadi kesalahan saat mengambil data!",
              showConfirmButton: false,
              timer: 1000,
            });
          }


        } else {
          throw new Error("No SR tidak ditemukan!");
        }
      } catch (error) {
        console.error("Error fetching data from BSI:", error);
        Swal.fire({
          icon: "error",
          title: error.message || "Terjadi kesalahan saat mengambil data!",
          showConfirmButton: false,
          timer: 1000,
        });
        clear();
      }
    }, 300);
  });

  function clear() {
    $('#no_sr').val('');
    $('#sr_date').val('');
    $('#customer_name').val('');
    $('#customer_recipient').val('');
    $('#customer_address').val('');
    $('#customer_telp').val('');
    $('#customer_fax').val('');
    $('#shipping_address').val('');
    $('#remaining_bill').val('');

    $('#store').prop('disabled', false);
  }

  $('#no_sr_reset').on('click', function () {
    clear();
  })
}