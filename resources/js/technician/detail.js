import * as alert from './../utils/alert';

$(function () {
  fetchData();
})

async function fetchData() {
  const no_vt = $('#no_vt').val();

  try {
    const response = await axios.get(`${APP_URL}/dashboard/technician/${no_vt}`);
    const result = response.data;

    if (!result.success) {
      return alert.showAlert('error', result.message);
    }

    $('.skeleton-loader').addClass('hidden');

    const data = result.data;

    $('#no_vt_label').append(data.NomorKunjungan);
    $('#kode_pegawai').append(data.NomorIdentitasTeknisi);
    $('#nama_pegawai').append(data.NamaTeknisi);
    $('#customer_contact').append(data.CustomerContact);
    $('#customer_address').append(data.AlamatLengkapKunjungan);
    $('#job_detail').removeClass('hidden');
    $('#job_detail').append(data.RincianPekerjaan);
    $('#weight_type').append(data.JenisTimbangan);
    $('#weight_size').append(data.Ukuran);
    $('#weight_capacity').append(data.Kapasitas);
    $('#indicator_type').append(data.TipeIndikator);
    $('#indicator_sn').append(data.TipeIndikatorSN);
    $('#loadcell_type').append(data.TipeLoadcell);
    $('#loadcell_sn').append(data.TipeLoadcellSN);
    $('#loadcell_qty').append(data.TipeJunctionBoxSN);
    $('#junction_type').append(data.TipeJunctionBox);
    $('#job_update').removeClass('hidden');
    $('#job_update').append(data.UpdatePekerjaan);
    $('#update_teknisi').append(data.UpdateTeknisi);
    $('#teknisi_telp').append(data.TeleponTeknisi);

    console.log(data);

  } catch (error) {
    alert.showAlert('error', 'Terjadi kesalahan', error.message);
  }


}