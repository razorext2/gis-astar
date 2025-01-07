export function showDatatables() {
    let table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        "lengthMenu": [10, 25, 50, 75, 100, -1],
        ajax: {
            url: index,
            type: "GET",
            data: function (d) {
                d.no_sr = $('#no_sr').val();
                d.title = $('#title').val();
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
            data: "no_sr",
            name: "no_sr",
        },
        {
            data: "title",
            name: "title"
        },
        {
            data: "payment_type",
            name: "payment_type"
        },
        {
            data: "created_at",
            name: "created_at",
        }],
        dom: `<"absolute top-1 md:left-0 mt-14 lg:mt-0 dark:text-white max-w-xs"B><"text-left lg:text-right dark:text-white"l><"relative overflow-x-auto w-full mt-20 lg:mt-4"t><"grid text-center gap-6 lg:grid-cols-2 mt-4 dark:text-white"<"lg:mt-3 lg:text-left"i><"lg:text-right dark:text-gray-900"p>>`,
        buttons: [{
            extend: "csv",
            exportOptions: {
                stripHtml: false
            }
        },
            "print",
        ],
        "deferRender": true,
        "language": {
            "infoFiltered": ""
        },
        createdRow: function (row, data, dataIndex) {
            // Add a custom class to the row
            $(row).addClass('border-b-[0.5px] h-14 dark:border-gray-800 border-gray-200 hover:bg-gray-50 dark:hover:bg-[#222226]'); // Replace 'custom-class' with your desired class name
        }
    });

    $('#cari').click(function () {
        // Ambil nilai dari semua input filter
        const filters = ['#title', '#title', '#no_sr', '#status', '#datepicker-range-start',
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
        const filters = ['#title', '#no_sr', '#status', '#datepicker-range-start',
            '#datepicker-range-end'
        ].map(selector => $(
            selector).val());
        // Cek apakah semua filter kosong
        if (filters.some(value => value !== '')) {

            // kosongkan semua value
            $('#title').val('');
            $('#no_sr').val('');
            $('#status').prop('selectedIndex', 0);
            $('#datepicker-range-start').val('');
            $('#datepicker-range-end').val('');

            table.draw();
        }
    })
}
