import * as alert from "../../../utils/alert";
import { clearForm } from "./clearForm";

export function submitHandler() {
  $('#store').on('click', async function () {
    const no_vt = $('#no_vt').val();

    // Create a plain object to hold the data
    const data = {
      no_vt: no_vt,
      id_permintaan: $('#id_permintaan').val(),
      kode_pegawai: $('#kode_pegawai').val(),
      customer_contact: $('#customer_contact').val(),
      customer_address: $('#customer_address').val(),
      job_detail: $('#job_detail').val(),
      size: $('#size').val(),
      capacity: $('#capacity').val(),
      indicator_type: $('#indicator_type').val(),
      indicator_sn: $('#indicator_sn').val(),
      loadcell_sn: $('#loadcell_sn').val(),
      loadcell_qty: $('#loadcell_qty').val(),
      junction_type: $('#junction_type').val(),
      job_update: $('#job_update').val(),
      visit_date: $('#visit_date').val(),
      point: $('#point').val(),
      partner: []
    };

    // Collect checked partner values
    $.each($("input[name='partner[]']:checked"), function () {
      data.partner.push({
        kode_pegawai: $(this).data('kode_pegawai'),
        no_vt: $(this).val()
      });

      // data.partner.push($(this).val());
    });

    // Handle weight type
    if ($('#weight_type').val() == 'Other') {
      data.weight_type = $('#other_weight_type').val();
    } else {
      data.weight_type = $('#weight_type').val();
    }

    // Handle loadcell type
    if ($('#weight_type').val() == 'Timbangan Jembatan') {
      data.loadcell_type = $('#other_loadcell_type').val();
    } else {
      data.loadcell_type = $('#loadcell_type').val();
    }

    alert.loadingAlert('Memproses data...');

    try {
      // Send the data object directly in the POST request
      const response = await axios.post(`${APP_URL}/dashboard/technician`, data);
      Swal.close();

      if (response.data.success) {
        alert.showAlert('success', response.data.message);
        $('#no_vt').val('');
        clearForm();
      } else {
        alert.showAlert('error', response.data.message, response.data.data);
      }
    } catch (error) {
      alert.showAlert('error', error.message);
    }
  });
}