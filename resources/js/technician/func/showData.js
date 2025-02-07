export function showData() {
  // Get the current URL
  const currentUrl = new URL(window.location.href);

  // Retrieve the status parameter from the URL
  const status = currentUrl.searchParams.get('status');

  let table = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lenghtMenu: [10, 25, 50, 75, 100, -1],
    ajax: {
      url: `${APP_URL}/dashboard/technician?status=${status}`,
      type: 'GET',
      data: function (d) {
        d.kode_pegawai = $('#kode_pegawai').val();
        d.no_vt = $('#no_vt').val();
        d.customer_name = $('#customer_name').val();
        d.total_data = $('#total_data').val();
        d.startDate = $('#datepicker-range-start').val();
        d.endDate = $('#datepicker-range-end').val();
      }
    },
    columns: [
      {
        data: 'DT_RowIndex',
        name: "DT_RowIndex",
        orderable: true,
      },
      {
        data: 'actions',
        name: 'actions',
        orderable: false,
      },
      {
        data: 'NomorIdentitasTeknisi',
        name: 'NomorIdentitasTeknisi'
      },
      {
        data: 'AlamatLengkapKunjungan',
        name: 'AlamatLengkapKunjungan'
      },
      {
        data: 'JenisTimbangan',
        name: 'JenisTimbangan',
      },
      {
        data: 'UpdateTeknisi',
        name: 'UpdateTeknisi'
      }],
    dom: `<"absolute top-1 md:left-0 mt-14 lg:mt-0 dark:text-white max-w-xs"B><"text-left lg:text-right dark:text-white"l><"relative overflow-x-auto w-full mt-20 lg:mt-4"t><"grid text-center gap-6 lg:grid-cols-2 mt-4 dark:text-white"<"lg:mt-3 lg:text-left"i><"lg:text-right dark:text-gray-900"p>>`,
    buttons: [{
      extend: "csv",
      exportOptions: {
        stripHtml: false
      }
    },
    {
      extend: "excel",
      exportOptions: {
        stripHtml: false,
        decodeEntities: false
      }
    },
      "print",
    ],
    "deferRender": true,
    "language": {
      "infoFiltered": ""
    }
  });

  setInterval(function () {
    table.ajax.reload();
  }, 60000);

  $('#cari').click(function () {
    // Ambil nilai dari semua input filter
    const filters = ['#total_data', '#datepicker-range-start',
      '#datepicker-range-end', '#kode_pegawai', '#no_vt', '#customer_name'
    ].map(selector => $(
      selector).val());

    // Cek apakah semua filter kosong
    if (filters.some(value => value !== '')) {
      table.draw();
    }
  });

  $('#clear').click(function () {
    // Ambil nilai dari semua input filter
    const filters = ['#total_data', '#datepicker-range-start',
      '#datepicker-range-end', '#kode_pegawai', '#no_vt', '#customer_name'
    ].map(selector => $(
      selector).val());
    // Cek apakah semua filter kosong
    if (filters.some(value => value !== '')) {

      // kosongkan semua value
      $('#total_data').val('');
      $('#kode_pegawai').val('');
      $('#no_vt').val('');
      $('#customer_name').val('');
      $('#datepicker-range-start').val('');
      $('#datepicker-range-end').val('');

      table.draw();
    }
  })
}