export function searchDataHandler() {
  let debounceTimer;
  $('#name').on('input', function () {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(() => {
      let query = $(this).val();

      if (query.length > 2) { // Mulai pencarian saat input lebih dari 2 karakter
        $.ajax({
          url: `/dashboard/pegawai/autocomplete`,
          type: "GET",
          data: {
            query: query
          },
          success: function (data) {
            $('#autocomplete-results').empty(); // Kosongkan hasil sebelumnya

            if (data.length > 0) {
              data.forEach((pegawai, index) => {
                // Jika ini adalah elemen terakhir, tambahkan kelas tambahan
                let roundedClass = (index === data.length - 1) ?
                  'rounded-b-lg' : '';

                $('#autocomplete-results').append(`
                                <div class="autocomplete-result bg-white border border-gray-300 dark:bg-white p-2.5 divide-y w-full ${roundedClass}" data-fullname="${pegawai.full_name}" data-id="${pegawai.kode_pegawai}">${pegawai.full_name}</div>
                            `);
              });
            } else {
              $('#autocomplete-results').append(
                '<div class="autocomplete-result">No results found</div>'
              );
            }
          },
          error: function (xhr, status, error) {
            console.error("Error: ", error);
            $('#autocomplete-results').append(
              '<div class="autocomplete-result text-red-500">Error loading results</div>'
            );
          }

        });
      } else {
        $('#autocomplete-results').empty(); // Kosongkan hasil jika input dihapus
      }
    }, 300);

  });

  // Saat hasil diklik, isi input dengan nilai yang dipilih
  $(document).on('click', '.autocomplete-result', function () {
    let name = $(this).data('fullname');
    let kodePegawai = $(this).data('id');

    // Isi input 'name' dengan nama yang dipilih
    $('#name').val(name);

    // Isi input 'kode_pegawai' dengan kode pegawai yang dipilih
    $('#kode_pegawai').val(kodePegawai);

    $('#autocomplete-results').empty(); // Kosongkan hasil setelah memilih
  });
}