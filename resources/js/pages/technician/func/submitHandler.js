import * as alert from "../../../utils/alert";
import { clearForm } from "./clearForm";

export function submitHandler() {
  $('#store').on('click', async function () {
    const no_vt = $('#no_vt').val();

    // Create a plain object to hold the data
    const data = {
      no_vt: no_vt,
      job_detail: $('#job_update').val(),
      size: $('#size').val(),
      capacity: $('#capacity').val(),
      indicator_type: $('#indicator_type').val(),
      indicator_sn: $('#indicator_sn').val(),
      loadcell_sn: $('#loadcell_sn').val(),
      junction_type: $('#junction_type').val(),
      junction_sn: $('#loadcell_qty').val(),
      partner: []
    };

    // Collect checked partner values
    $.each($("input[name='partner[]']:checked"), function () {
      data.partner.push($(this).val());
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

        alert.showAlert('success', response.data.data.message);
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