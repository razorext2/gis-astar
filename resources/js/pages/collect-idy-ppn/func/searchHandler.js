import { showAlert, loadingAlert } from '../../../utils/alert';

export function searchDataHandler() {
  $('#no_sr_submit').on('click', async function () {
    let no_sr = $('#no_sr').val();

    loadingAlert("Memproses data...");

    if (no_sr == '') {
      Swal.close();
      showAlert('error', 'Terjadi kesalahan!', 'No. SR tidak boleh kosong!');
      return;
    }

    try {
      const [database, BSI] = await Promise.all([
        axios.get(`/api/collect-idy-ppn-api/getSR/${no_sr}`).catch(err => err.response),
        axios.get(`/proxy/idy/ppn`, { params: { no_sr } }).catch(err => err.response)
      ]);

      let check = database && database.data && database.data.success;

      if (check) {
        let status = database.data.data.bill_status;

        if (status != 2) {
          const data = database.data.data;

          $('#sr_date').val(data.sr_date);
          $('#sales_invoice').val(data.sales_invoice);
          $('#tax_invoice').val(data.tax_invoice);
          $('#customer_name').val(data.customer_name);
          $('#customer_recipient').val(data.customer_recipient);
          $('#customer_address').val(data.customer_address);
          $('#customer_telp').val(data.customer_telp);
          $('#customer_fax').val(data.customer_fax);
          $('#shipping_address').val(data.shipping_address);
          $('#remaining_bill').val(data.remaining_bill);

          let sisaBsi = BSI && BSI.status === 200 && BSI.data && BSI.data.data && BSI.data.data[0] ? BSI.data.data[0].SisaPiutang : 0;
          $('#remaining_bill_bsi').val(sisaBsi);
          $('#total_bill').val(data.total_bill);

          Swal.close();
        } else {
          Swal.close();
          showAlert('error', 'Terjadi kesalahan saat mengambil data!', `Tagihan dengan kode: ${no_sr} ditemukan, namun statusnya sudah ditutup.`);
        }
      } else {
        let checkBSI = BSI && BSI.status === 200 && BSI.data && BSI.data.status === 'success';

        if (checkBSI) {
          const data = BSI.data.data[0];

          $('#sr_date').val(data.TanggalPenjualan.date);
          $('#sales_invoice').val(data.NomorPenjualan);
          $('#tax_invoice').val(data.NomorFakturPajak);
          $('#customer_name').val(data.NamaCustomer);
          $('#customer_recipient').val(data.CustomerContact);
          $('#customer_address').val(data.AlamatContact);
          $('#customer_telp').val('0');
          $('#customer_fax').val('0');
          $('#shipping_address').val(data.CustomerContact);
          $('#remaining_bill_bsi').val(data.SisaPiutang);
          $('#remaining_bill').val(data.SisaPiutang);
          $('#total_bill').val(data.Total);

          Swal.close();
        } else {
          Swal.close();
          clear();
          showAlert('error', 'Terjadi kesalahan saat mengambil data!', `Tagihan dengan kode: ${no_sr} tidak ditemukan.`);
        }
      }
    } catch (error) {
      console.error("Error fetching data:", error);
      if (error.response) {
        console.error("Server response:", error.response.data);
      }
      Swal.close();
      return showAlert('error', 'Terjadi kesalahan saat mengambil data!', error.response?.data?.message || error.message);
    }
  });

  $('#no_sr').on('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      $('#no_sr_submit').trigger('click');
    }
  });

  const clear = () => $('#collect-idy-ppn input, #collect-idy-ppn select, #collect-idy-ppn textarea').val('');

  $('#no_sr_reset').on('click', function () {
    clear();
    Swal.close();
  });
}
