import * as alert from '../../utils/alert';
import { clearForm } from './clearForm';

export function fetchDataHandler() {
  // panggil fungsi weightChanged
  weightChanged();

  let no_vt = $('#no_vt').val();

  if (no_vt != '') {
    fetchDataAsync();
  }

  $('#no_vt_submit').on('click', async function () {
    fetchDataAsync();
  });
}

async function fetchDataAsync() {
  $('#partner_parent').addClass('hidden');
  $('#partner_child').empty();

  if ($('#no_vt').val() == '') {
    return alert.showAlert('error', 'Nomor Kunjungan tidak boleh kosong!');
  }

  alert.loadingAlert("Sedang mencari data...");

  try {
    const response = await axios.get(`${APP_URL}/proxy/get/vt`, {
      params: {
        no_vt: $('#no_vt').val(),
      },
    });
    const result = response.data;
    const arrTimb = {
      data: [
        'Single Deck',
        'Floor Scale',
        'Hopper',
        'Tangki',
        'Conveyer',
        'Check Weigher',
        'Timbangan Jembatan',
      ]
    }

    if (!result.success) {
      clearForm();
      return alert.showAlert('error', result.message, result.data);
    }

    Swal.close();
    alert.showAlert('success', result.message);

    const data = result.data.data[0];

    $('#customer_contact').val(data.CustomerContact);
    $('#customer_address').val(data.AlamatLengkapKunjungan);
    $('#job_detail').val(data.RincianPekerjaan);
    $('#size').val(data.Ukuran);
    $('#capacity').val(data.Kapasitas);
    $('#indicator_type').val(data.TipeIndikator);
    $('#indicator_sn').val(data.TipeIndikatorSN);
    $('#loadcell_type').val(data.TipeLoadcell);
    $('#loadcell_qty').val(data.TipeJunctionBoxSN);
    $('#loadcell_sn').val(data.TipeLoadcellSN);
    $('#junction_type').val(data.TipeJunctionBox);
    $('#junction_sn').val(data.TipeJunctionBoxSN);
    $('#job_update').val(data.UpdatePekerjaan);
    $('#weight_type option[value="' + data.JenisTimbangan + '"]').prop('selected', true).trigger('change');

    // jika jenis timbangan tidak ada di array data
    if (!arrTimb.data.includes(data.JenisTimbangan)) {
      $('#other_weight_type').removeClass('hidden'); // tampilkan other_weight_type
      $('#other_weight_type').val(data.JenisTimbangan); // isi other_weight_type
      $('#weight_type option[value="Other"]').prop('selected', true).trigger('change'); // pilih weight_type
    }

    // jika Timbangan Jembatan,
    if (data.JenisTimbangan == 'Timbangan Jembatan') {
      $('#other_loadcell_type').removeClass('hidden'); // tampilkan other_loadcell_type 
      $('#other_loadcell_type').val(data.TipeLoadcell); // isi other_loadcell_type
      $('#loadcell_type option[value="' + data.TipeLoadcell + '"]').prop('selected', true).trigger('change'); // pilih loadcell_type
    }

    // tampilkan container #partner_parent
    $('#partner_parent').removeClass('hidden');

    // foreach data partner
    result.data.data[0].partner.forEach(items => {
      // append element ke container
      $('#partner_child').append(`
        <div class="mb-4 flex items-center">
					<input class="h-4 w-4 rounded-sm border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600" id="checkbox-${items.NomorKunjungan}" name="partner[]" type="checkbox" value="${items.NomorKunjungan}">
					<div class="flex flex-col ms-2.5" for="checkbox-${items.NomorKunjungan}">
            <span class="text-xs font-medium text-gray-900 dark:text-gray-300">${items.NomorKunjungan}</span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-300">${items.NamaTeknisi}</span>
          </div>
				</div>
        `);

      if (items.NomorKunjungan == data.NomorKunjungan) {
        $('#checkbox-' + items.NomorKunjungan).prop('checked', true);
      }
    });
  } catch (error) {
    clearForm();
    alert.showAlert('error', 'Failed to fetch data', error.message);
  }
}

function weightChanged() {
  $('#weight_type').on('change', function () {

    $('#other_weight_type').addClass('hidden')
    $('#other_loadcell_type').addClass('hidden')
    $('#loadcell_type').removeClass('hidden');

    if (this.value == 'Other') {
      $('#other_weight_type').removeClass('hidden');
    }

    if (this.value == 'Timbangan Jembatan') {
      $('#other_loadcell_type').removeClass('hidden');
      $('#loadcell_type').addClass('hidden');
    }
  })
}