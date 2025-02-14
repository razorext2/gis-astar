export function showData() {
  /**
   * Show data in the table
   * @param {Object} e event
   */
  let table = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    "lengthMenu": [10, 25, 50, 75, 100, -1],
    ajax: {
      url: showDataUrl,
      type: "GET",
      data: function (d) {
        d.kode_pegawai = $('#kode_pegawai').val();
        d.title = $('#title').val();
        d.customer_name = $('#customer_name').val();
        d.status = $('#status').val();
        d.startDate = $('#datepicker-range-start').val();
        d.endDate = $('#datepicker-range-end').val();
      }
    },
    columns: [{
      data: "DT_RowIndex",
      name: "DT_RowIndex",
      orderable: false,
    }, {
      data: 'actions',
      name: 'actions',
      orderable: false,
    }, {
      data: "kode_pegawai",
      name: "kode_pegawai",
    },
    {
      data: "title",
      name: "title",
    },
    {
      data: "customer_name",
      name: "customer_name",
    },
    {
      data: "lokasi",
      name: "lokasi",
    },
    {
      data: "created_at",
      name: "created_at",
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

  setInterval(function () {
    table.ajax.reload();
  }, 60000);

  /**
   * Apply filters to the table
   * @param {Object} e event
   */
  $('#cari').click(function (e) {
    // Get the values of the filters
    const filters = [
      $('#kode_pegawai').val(),
      $('#title').val(),
      $('#customer_name').val(),
      $('#status').val(),
      $('#datepicker-range-start').val(),
      $('#datepicker-range-end').val()
    ];

    // Apply filters
    if (filters.some(value => value !== '')) {
      table.draw();
    }
  });

  /**
   * Clear the filters and redraw the table
   * @param {Object} e event
   */
  $('#clear').click(function (e) {
    // Get the values of the filters
    const filters = [
      $('#kode_pegawai').val(),
      $('#title').val(),
      $('#customer_name').val(),
      $('#status').val(),
      $('#datepicker-range-start').val(),
      $('#datepicker-range-end').val()
    ];

    // Clear filters
    if (filters.some(value => value !== '')) {
      $('#kode_pegawai').val('');
      $('#title').val('');
      $('#customer_name').val('');
      $('#status').val('');
      $('#datepicker-range-start').val('');
      $('#datepicker-range-end').val('');
      table.draw();
    }
  });
}