import { capturedImages } from '../../../utils/cameraStream';
import * as alert from "../../../utils/alert";
import { clearForm } from "./clearForm";

export function submitHandler() {
  $('#store').on('click', async function (e) {
    e.preventDefault();

    const $button = $(this);
    $button.prop('disabled', true);

    let formData = new FormData();

    formData.append("no_vt", $("#no_vt").val());
    formData.append("id_permintaan", $("#id_permintaan").val());
    formData.append("kode_pegawai", $("#kode_pegawai").val());
    formData.append("customer_contact", $("#customer_contact").val());
    formData.append("customer_address", $("#customer_address").val());
    formData.append("job_detail", $("#job_detail").val());

    // formData.append("size", $("#size").val());
    formData.append("size", `${$("#length").val()}x${$("#width").val()}`);

    formData.append("capacity", $("#capacity").val());
    formData.append("indicator_type", $("#indicator_type").val());
    formData.append("indicator_sn", $("#indicator_sn").val());
    formData.append("loadcell_sn", $("#loadcell_sn").val());
    formData.append("loadcell_qty", $("#loadcell_qty").val());
    formData.append("junction_type", $("#junction_type").val());
    formData.append("job_update", $("#job_update").val());
    formData.append("visit_date", $("#visit_date").val());
    formData.append("point", $("#point").val());
    formData.append("partner", []);

    for (const [index, image] of capturedImages.entries()) {
      const blob = await dataURItoBlob(image);
      formData.append("images[]", blob, `image${index}.png`);
    }

    // Collect checked partner values
    $.each($("input[name='partner[]']:checked"), function () {
      formData.append("partner[]", JSON.stringify({
        kode_pegawai: $(this).data('kode_pegawai'),
        no_vt: $(this).val()
      }));
    });

    // Handle weight type
    if ($('#weight_type').val() == 'Other') {
      formData.append("weight_type", $('#other_weight_type').val());
    } else {
      formData.append("weight_type", $('#weight_type').val());
    }

    // Handle loadcell type
    if ($('#loadcell_type').val() == 'Timbangan Jembatan') {
      formData.append("loadcell_type", $('#other_loadcell_type').val());
    } else {
      formData.append("loadcell_type", $('#loadcell_type').val());
    }

    alert.loadingAlert('Memproses data...');

    try {
      // Send the data object directly in the POST request
      const response = await axios.post(`${APP_URL}/dashboard/technician`, formData);
      Swal.close();

      if (response.data.success) {
        alert.showAlert('success', response.data.message);
        $('#no_vt').val('');

        // focus
        document.getElementById('no_vt').focus();

        // disabled false
        $button.prop('disabled', false);

        // kosongkan kontainer dokumentasi
        document.getElementById('captured-images').innerHTML = '';
        clearForm();
      } else {
        $button.prop('disabled', false);
        alert.showAlert('error', response.data.message, response.data.data);
      }
    } catch (error) {
      alert.showAlert('error', error.message);
    }
  });
}

async function dataURItoBlob(dataURI) {
  const response = await axios.get(dataURI, { responseType: 'blob' });
  return response.data;
}