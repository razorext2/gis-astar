export function searchDataHandler() {
  let debounceTimer;
  $('#no_sr_submit').on('click', function () {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(async () => {
      let no_sr = $('#no_sr').val();

      try { // menggunakan blok try catch untuk penanganan error
        const database = await axios.get(`${APP_URL}/api/collect-task-api/getSR/${no_sr}`); // ambil data dari endpoint database
        let check = database.data.success // ambil kondisi dari value 'success'

        // check jika ada data di database
        if (check) { // jika data ditemukan dari database, fetch data dari database.
          console.log('Data ditemukan.');

          let status = database.data.data.bill_status; // ambil nilai bill_status

          if (status != 2) { // jika bill_status != 2, maka:
            const data = database.data.data;

            $('#sr_date').val(data.sr_date);
            $('#customer_name').val(data.customer_name);
            $('#customer_recipient').val(data.customer_recipient);
            $('#customer_address').val(data.customer_address);
            $('#customer_telp').val(data.customer_telp);
            $('#customer_fax').val(data.customer_fax);
            $('#shipping_address').val(data.shipping_address);
            $('#remaining_bill').val(data.remaining_bill);
            $('#total_bill').val(data.total_bill);

          } else {
            Swal.fire({ // tampilkan error
              icon: "error",
              title: "Terjadi kesalahan.",
              html: `Tagihan dengan kode: <b> ${no_sr} </b> ditemukan, namun statusnya sudah ditutup.`
            });
          }


        } else { // jika data tidak ditemukan dari database, lalu lakukan fetch data dari BSI
          try {
            const BSI = await axios.get(`${APP_URL}/proxy/fetchSR`, { // ambil data dari endpoint BSI
              params: { // set parameter
                no_sr: no_sr, // atur param dengan nama no_sr yang mengambil nilai dari "let no_sr = $('#no_sr').val();"
              }
            });

            let check = BSI.data.status;  // ambil kondisi dari value 'success'

            if (check == 'success') { // jika data ditemukan di BSI
              console.log('data ditemukan dari bsi');
              // fetch data ke masing masing input form
              const data = BSI.data.data[0];
              $('#sr_date').val(data.TanggalPermintaanJual.date);
              $('#customer_name').val(data.NamaCustomer);
              $('#customer_recipient').val(data.CustomerContact);
              $('#customer_address').val(data.AlamatContact);
              $('#customer_telp').val(data.TeleponContact);
              $('#customer_fax').val(data.FaxContact);
              $('#shipping_address').val(data.AlamatKirim);
              $('#remaining_bill').val(data.Total);
              $('#total_bill').val(data.Total);
            } else { // jika data tidak ditemukan di BSI 
              $('#no_sr').val('');  // kosongkan input no_sr

              Swal.fire({  // tampilkan sweetalert
                icon: "error",
                title: `Terjadi kesalahan.`,
                html: `Data dengan kode: <b> ${no_sr} </b>, tidak ditemukan!`,
                showConfirmButton: true,
              });
            }
          } catch (error) { // catch error jika terjadi kesalahan saat fetch data dari BSI
            console.error("Error fetching data from database:", error); // print error

            Swal.fire({ // tampilkan sweetalert
              icon: "error",
              title: error.message || "Terjadi kesalahan saat mengambil data dari BSI!",
              showConfirmButton: true,
            });
          }
        }
      } catch (error) { // catch error jika terjadi kesalahan saat fetch data dari database
        console.error("Error fetching data from database:", error); // print error

        Swal.fire({  // tampilkan sweetalert
          icon: "error",
          title: error.message || "Terjadi kesalahan saat mengambil data dari database!",
          showConfirmButton: true,
        });

      }

      // Cari data SR di API BSI
      // try {
      //   const responseBSI = await axios.get(`${APP_URL}/proxy/fetchSR`, {
      //     params: { NomorPermintaanJual: no_sr }
      //   });

      //   if (responseBSI.data && responseBSI.data.data) {
      //     const data = responseBSI.data.data[0];
      //     $('#sr_date').val(data.TanggalPermintaanJual.date);
      //     $('#customer_name').val(data.NamaCustomer);
      //     $('#customer_recipient').val(data.CustomerContact);
      //     $('#customer_address').val(data.AlamatContact);
      //     $('#customer_telp').val(data.TeleponContact);
      //     $('#customer_fax').val(data.FaxContact);
      //     $('#shipping_address').val(data.AlamatKirim);

      //     // Cari data SR di database
      //     try {
      //       const responseDB = await axios.get(`${APP_URL}/api/collect-task-api/getSR/${no_sr}`);

      //       if (responseDB.data && responseDB.data.data) {
      //         // console.log('dari db')
      //         $('#remaining_bill').val(responseBSI.data.data[0].Total);
      //         $('#total_bill').val(responseDB.data.data.total_bill);
      //       } else {
      //         // console.log('dari bsi')
      //         $('#remaining_bill').val(responseBSI.data.data[0].Total);
      //         $('#total_bill').val(responseBSI.data.data[0].Total);
      //       }
      //     } catch (error) {
      //       console.error("Error fetching data from database:", error);
      //       Swal.fire({
      //         icon: "error",
      //         title: error.message || "Terjadi kesalahan saat mengambil data!",
      //         showConfirmButton: false,
      //         timer: 1000,
      //       });
      //     }


      //   } else {
      //     throw new Error("No SR tidak ditemukan!");
      //   }
      // } catch (error) {
      //   console.error("Error fetching data from BSI:", error);
      //   Swal.fire({
      //     icon: "error",
      //     title: error.message || "Terjadi kesalahan saat mengambil data!",
      //     showConfirmButton: false,
      //     timer: 1000,
      //   });
      //   clear();
      // }
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