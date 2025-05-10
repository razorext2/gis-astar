import { showAlert, loadingAlert } from '../../../utils/alert';
import { handleFormErrors } from '../../../utils/handleFormErrors';

export function addDataHandler() {
  $('#store').click(async function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    loadingAlert("Menyimpan...");

    let formData = new FormData();
    formData.append("no_sr", $("#no_sr").val());
    formData.append("sales_invoice", $("#sales_invoice").val());
    formData.append("tax_invoice", $("#tax_invoice").val());
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

    if ($('#remaining_bill').val() != $('#remaining_bill_bsi').val()) {
      Swal.close();
      $button.prop('disabled', false);
      showAlert('error', 'Sisa tagihan tidak sama.', 'Hubungi IT untuk pengecekan data lebih lanjut.');
      return;
    }

    try {
      const response = await axios.post(`${APP_URL}/api/collect-task-ppn-api`, formData);
      if (response.data.success) {
        Swal.close();
        showAlert('success', response.data.message);
        setTimeout(() => window.location.reload(), 1500);
      } else {
        Swal.close();
        $button.prop('disabled', false);
        handleFormErrors(response.data.data);
        showAlert('error', response.data.message)
      }
    } catch (error) {
      Swal.close();
      console.error('Error:', error);
      $button.prop('disabled', false);
      showAlert('error', 'Terjadi kesalahan.', error.message);
    }
  });

  $('input, textarea, select').on('input change', function () {
    const field = $(this).attr('id');
    const $alertElement = $(`#alert-${field}`);
    if ($alertElement.length) {
      $alertElement.addClass('hidden').html('');
    }
  });
}