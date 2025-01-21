import Swal from "sweetalert2";

export function searchDataHandler() {
  $('#no_sr_submit').on('click', async function () {
    let no_sr = $('#no_sr').val();

    if (no_sr == '') {
      Swal.fire({
        icon: "error",
        title: "Terjadi kesalahan.",
        html: "No. SR <b>tidak boleh kosong!</b>"
      });
      return;
    }

    Swal.fire({
      title: "Memproses data...",
      showConfirmButton: false,
      allowOutsideClick: false,
      willOpen: () => Swal.showLoading()
    });

    try {
      const [database, BSI] = await Promise.all([
        axios.get(`${APP_URL}/api/collect-task-api/getSR/${no_sr}`),
        axios.get(`${APP_URL}/proxy/idc/tagihan`, { params: { no_sr } })
      ]);

      let check = database.data.success;

      console.log('check database: ' + check);

      if (check) {
        let status = database.data.data.bill_status;

        if (status != 2) {
          const data = database.data.data;
          console.log('data diambil dari database');

          $('#sr_date').val(data.sr_date);
          $('#customer_name').val(data.customer_name);
          $('#customer_recipient').val(data.customer_recipient);
          $('#customer_address').val(data.customer_address);
          $('#customer_telp').val(data.customer_telp);
          $('#customer_fax').val(data.customer_fax);
          $('#shipping_address').val(data.shipping_address);
          $('#remaining_bill').val(data.remaining_bill);
          $('#remaining_bill_bsi').val(BSI.data.data[0].SisaPiutang);
          $('#total_bill').val(data.total_bill);

          Swal.close();
        } else {
          Swal.fire({
            icon: "error",
            title: "Terjadi kesalahan.",
            html: `Tagihan dengan kode: <b> ${no_sr} </b> ditemukan, namun statusnya sudah ditutup.`
          });
        }
      } else {
        let check = BSI.data.status;

        console.log('check bsi: ' + check);

        if (check == 'success') {
          const data = BSI.data.data[0];
          console.log('data diambil dari BSI');

          $('#sr_date').val(data.TanggalPermintaanJual.date);
          $('#customer_name').val(data.NamaCustomer);
          $('#customer_recipient').val(data.CustomerContact);
          $('#customer_address').val(data.AlamatContact);
          $('#customer_telp').val(data.TeleponContact);
          $('#customer_fax').val(data.FaxContact);
          $('#shipping_address').val(data.AlamatKirim);
          $('#remaining_bill_bsi').val(data.SisaPiutang);
          $('#remaining_bill').val(data.SisaPiutang);
          $('#total_bill').val(data.Total);

          Swal.close();
        } else {
          clear();

          Swal.fire({
            icon: "error",
            title: "Terjadi kesalahan.",
            html: `Tagihan dengan kode: <b> ${no_sr} </b> tidak ditemukan.`
          })
        }
      }
    } catch (error) {
      console.error("Error fetching data:", error);
      Swal.fire({
        icon: "error",
        title: error.message || "Terjadi kesalahan saat mengambil data!",
        showConfirmButton: true
      });
    }
  });

  const clear = () => $('#collect-task input, #collect-task select, #collect-task textarea').val('');

  $('#no_sr_reset').on('click', function () {
    clear();
  });
}
