import * as alert from "../../../utils/alert";
import { clearForm } from "./clearForm";

export function submitHandler() {
  $('#store').on('click', async function (e) {
    // inisiasi variabel
    const $button = $(this); // tombol
    const document = $('#bast_document')[0].files[0] // file document
    let formData = new FormData();

    // inisiasi prevent default
    e.preventDefault();

    // set tombol jadi disabled
    $button.prop('disabled', true);

    // inisiasi form data
    formData.append("no_vt", $("#no_vt").val());
    formData.append("id_permintaan", $("#id_permintaan").val());
    formData.append("kode_pegawai", $("#kode_pegawai").val());
    formData.append("customer_contact", $("#customer_contact").val());
    formData.append("customer_address", $("#customer_address").val());
    formData.append("job_detail", $("#job_detail").val());
    formData.append("size", `${$("#length").val()}x${$("#width").val()}`);
    formData.append("capacity", $("#capacity").val());
    formData.append("indicator_type", $("#indicator_type").val());
    formData.append("indicator_sn", $("#indicator_sn").val());
    formData.append("loadcell_sn", $("#loadcell_sn").val());
    formData.append("loadcell_qty", $("#loadcell_qty").val());
    formData.append("junction_type", $("#junction_type").val());
    formData.append("job_update", $("#job_update").val());
    formData.append("visit_date", $("#visit_date").val());
    formData.append("status", $('#status').val());
    formData.append("point", $("#point").val());
    formData.append("partner", []);
    formData.append("bast_document", document);

    // kalo ada partner yang dichecklist
    $.each($("input[name='partner[]']:checked"), function () {
      formData.append("partner[]", JSON.stringify({
        kode_pegawai: $(this).data('kode_pegawai'),
        no_vt: $(this).val()
      }));
    });

    // logika untuk weight_type
    if ($('#weight_type').val() === 'Other') {
      formData.append("weight_type", $('#other_weight_type').val());
    } else {
      formData.append("weight_type", $('#weight_type').val());
    }

    // logika untuk loadcell_type
    if ($('#weight_type').val() === 'Timbangan Jembatan') {
      formData.append("loadcell_type", $('#other_loadcell_type').val());
    } else {
      formData.append("loadcell_type", $('#loadcell_type').val());
    }

    alert.loadingAlert('Memproses data...');

    try {
      // kirim data object langsung di POST request
      const response = await axios.post(`/dashboard/technician`, formData);
      Swal.close();

      if (response.data.success) {
        alert.showAlert('success', response.data.message);
        $('#no_vt').val('');

        // disabled false
        $button.prop('disabled', false);

        setTimeout(() => {
          window.location.href = "/dashboard/technician";
        }, 1500);
      } else {
        $button.prop('disabled', false);
        alert.showAlert('error', response.data.message, response.data.data);
      }
    } catch (error) {
      alert.showAlert('error', error.message);
    }
  });
}