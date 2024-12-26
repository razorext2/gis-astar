export function showDatatables() {
  // Initialize DataTable
  let table = $('#table-dayoff').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    paging: true,
    "lengthMenu": [15, 25, 50, 75, 100, -1],
    ajax: {
      url: dayoffIndex,
      data: function (d) {
        d.dayoff_for = $('#dayoff-for').val();
        d.kode_pegawai = $('#kode-pegawai').val();
        d.status = $('#status').val();
        d.startDate = $('#datepicker-range-start').val();
        d.endDate = $('#datepicker-range-end').val();
      }
    },
    columns: [{
      data: "DT_RowIndex",
      name: "DT_RowIndex",
      orderable: false,
    },
    {
      data: 'actions',
      name: 'actions',
      orderable: false,
    },
    {
      data: 'kode_pegawai',
      name: 'kode_pegawai'
    },
    {
      data: 'status',
      name: 'status'
    },
    {
      data: 'tgl_dari',
      name: 'tgl_dari'
    },
    {
      data: 'created_at',
      name: 'created_at'
    },
    {
      data: "status",
      name: "status",
      visible: false,
    }],
    order: [
      [5, 'desc'],
    ],
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

  $('#cari').click(function () {
    // Ambil nilai dari semua input filter
    const filters = ['#dayoff-for', '#kode-pegawai', '#status', '#datepicker-range-start',
      '#datepicker-range-end'
    ].map(selector => $(
      selector).val());

    // Cek apakah semua filter kosong
    if (filters.some(value => value !== '')) {
      table.draw();
    }
  });

  // jika tombol clear diklik
  $('#clear').click(function () {
    // Ambil nilai dari semua input filter
    const filters = ['#dayoff-for', '#kode-pegawai', '#status', '#datepicker-range-start',
      '#datepicker-range-end'
    ].map(selector => $(
      selector).val());
    // Cek apakah semua filter kosong
    if (filters.some(value => value !== '')) {

      // kosongkan semua value
      $('#dayoff-for').val('');
      $('#kode-pegawai').val('');
      $('#status').prop('selectedIndex', 0);
      $('#datepicker-range-start').val('');
      $('#datepicker-range-end').val('');

      table.draw();
    }
  });
}