export function clearForm() {
  $('#kode_pegawai').val('');
  $('#employee_name').val('');
  $('#id_permintaan').val('');
  $('#visit_date').val('');
  $('#customer_contact').val('');
  $('#customer_address').val('');
  $('#job_detail').val('');
  $('#size').val('');
  $('#capacity').val('');
  $('#indicator_type').val('');
  $('#indicator_sn').val('');
  $('#loadcell_type').val('');
  $('#loadcell_qty').val('');
  $('#loadcell_sn').val('');
  $('#junction_type').val('');
  $('#junction_sn').val('');
  $('#job_update').val('');
  $('#point').val('');
  $('#weight_type option[value=""]').prop('selected', true).trigger('change');
  $('#partner_parent').addClass('hidden');
  $('#partner_child').empty();
}