export function searchPegawaiHandler() {
  let debounceTimer;
  $('#full_name').on('input', function () {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(() => {
      let query = $(this).val();

      if (query.length > 0) {
        axios.get(pegawaiSearch, { params: { query: query } })
          .then(response => {
            const data = response.data;
            $('#autocomplete-pegawai-results').empty();

            if (data.length > 0) {
              data.forEach((pegawai, index) => {
                let roundedClass = (index === data.length - 1) ? 'rounded-b-lg' : '';
                $('#autocomplete-pegawai-results').append(`
                  <div class="autocomplete-result bg-white border border-gray-300 dark:bg-white p-2.5 divide-y w-full ${roundedClass}" data-fullname="${pegawai.name}" data-id="${pegawai.kode_pegawai}">
                    ${pegawai.name}
                  </div>
                `);
              });
            } else {
              $('#autocomplete-pegawai-results').append(
                '<div class="bg-white border border-gray-300 dark:bg-white p-2.5 divide-y w-full rounded-b-lg">No results found</div>'
              );
            }
          })
          .catch(error => {
            console.error("Error: ", error);
            $('#autocomplete-pegawai-results').append(
              '<div class="bg-white border border-gray-300 dark:bg-white p-2.5 divide-y w-full rounded-b-lg">Error loading results</div>'
            );
          });
      } else {
        $('#autocomplete-pegawai-results').empty();
      }
    }, 300);
  });

  $(document).on('click', '.autocomplete-result', function () {
    let name = $(this).data('fullname');
    let kodePegawai = $(this).data('id');
    $('#full_name').val(name);
    $('#kode_pegawai').val(kodePegawai);
    $('#autocomplete-pegawai-results').empty();
  });
}

export function searchSRHandler() {
  let debounceTimer;
  $('#no_sr').on('input', function () {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(() => {
      let query = $(this).val();

      if (query.length > 1) {
        axios.get(srSearch, { params: { query: query } })
          .then(response => {
            const data = response.data;
            $('#autocomplete-collect-task-ppn-container').empty();

            if (data.length > 0) {
              data.forEach((collectTask, index) => {
                let roundedClass = (index === data.length - 1) ? 'rounded-b-lg' : '';
                $('#autocomplete-collect-task-ppn-container').append(`
                  <div class="autocomplete-collect-task-ppn-item bg-white border border-gray-300 dark:bg-white p-2.5 divide-y w-full ${roundedClass}" data-nosr="${collectTask.no_sr}" data-id="${collectTask.id}">
                    ${collectTask.no_sr} | ${collectTask.customer_name}
                  </div>
                `);
              });
            } else {
              $('#autocomplete-collect-task-ppn-container').append(
                '<div class="bg-white border border-gray-300 dark:bg-white p-2.5 divide-y w-full rounded-b-lg">No results found</div>'
              );
            }
          })
          .catch(error => {
            console.error("Error: ", error);
            $('#autocomplete-collect-task-ppn-container').append(
              '<div class="bg-white border border-gray-300 dark:bg-white p-2.5 divide-y w-full rounded-b-lg">Error loading results</div>'
            );
          });
      } else {
        $('#autocomplete-collect-task-ppn-container').empty();
      }
    }, 300);
  });

  $(document).on('click', '.autocomplete-collect-task-ppn-item', function () {
    let id = $(this).data('id');
    let noSR = $(this).data('nosr');

    if (!id || !noSR) {
      console.error("Data 'id' atau 'noSR' tidak ditemukan.");
      return;
    }

    if ($('#no_sr').length) {
      $('#no_sr').val('');
    }

    $('#empty').addClass('hidden');

    if ($(`#sr_${id}`).length === 0) {
      $('#selected-container').append(`
        <div id="item-container-${id}" class="flex items-center mx-auto w-full">
          <input
            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
            id="sr_${id}" name="sr_data[]" value="${noSR}" type="text" readonly />
          <button type="button" id="removeSR-${id}" class="p-2.5 ms-2 text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
            </svg>
            <span class="sr-only">Hapus</span>
          </button>
        </div>
      `);

      $(`#removeSR-${id}`).click(function () {
        $(`#item-container-${id}`).remove();
        if ($('input[name="sr_data[]"]').length === 0) {
          $('#empty').removeClass('hidden');
        }
      });
    } else {
      showAlert('error', 'No. SR sudah ada dalam list!');
    }

    $('#autocomplete-collect-task-ppn-container').empty();
  });
}
