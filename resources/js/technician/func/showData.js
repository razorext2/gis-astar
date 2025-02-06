export function showData() {
  let table = $('#dataTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lenghtMenu: [10, 25, 50, 75, 100, -1],
    ajax: {
      url: `${APP_URL}/dashboard/technician`,
      type: 'GET',
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
}