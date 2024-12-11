@extends('dashboard.layoutsDash.app')
@section('content')
  <form id="add-dayoff" action="{{ route('dayoff.create') }}"></form>

  <div class="relative grid grid-cols-1 gap-6">

    @can('dayoff-create')
      <div class="max-w-xs">
        <x-button.success id="add-button" form="add-dayoff" type="submit">
          <x-slot name="icon">
            <x-icons.arrow-left class="icon h-6 w-6 rotate-180 dark:fill-white" />
          </x-slot>
          Tambah Data
        </x-button.success>
      </div>
    @endcan

    <div class="flex h-auto items-center justify-center">
      <div
        class="grid w-full grid-cols-2 gap-4 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700">

        <div class="col-span-2">
          <x-filter.filter-bar>
            <div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
              <x-filter.filter-input-text id="kode-pegawai" name="kode-pegawai" :text="'kode pegawai'">
                <x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
              </x-filter.filter-input-text>
            </div>

            <div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
              <x-filter.date-range />
            </div>

            <div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
              <x-filter.filter-input-select id="dayoff-for" name="dayoff-for" :options="['Izin' => 'Izin', 'Sakit' => 'Sakit', 'Absen' => 'Absen', 'PC' => 'Pulang Cepat']"
                default-option="Filter by izin" />
            </div>

            <div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
              <x-filter.filter-input-select id="status" name="status" :options="['0' => 'Dibatalkan', '1' => 'Diterima', '2' => 'Diajukan', '3' => 'Ditolak']"
                default-option="Filter by status" />
            </div>

          </x-filter.filter-bar>
        </div>

        <div class="col-span-2">
          <table class="mt-20 w-full text-left text-sm text-gray-500 dark:text-gray-300 sm:mt-4" id="table-dayoff">
            <thead class="text-xs uppercase">
              <tr>
                <th>
                  <span class="flex items-center text-gray-800 dark:text-white">
                    #
                  </span>
                </th>
                <th>
                  <span class="flex items-center text-gray-800 dark:text-white">
                    Action
                  </span>
                </th>
                <th>
                  <span class="flex items-center text-gray-800 dark:text-white">
                    ID User
                  </span>
                </th>
                <th>
                  <span class="flex items-center text-gray-800 dark:text-white">
                    Dayoff For
                  </span>
                </th>
                <th>
                  <span class="flex items-center text-gray-800 dark:text-white">
                    Tanggal Dari
                  </span>
                </th>
                <th>
                  <span class="flex items-center text-gray-800 dark:text-white">
                    Tanggal Hingga
                  </span>
                </th>
                <th>
                  <span class="flex items-center text-gray-800 dark:text-white">
                    Status
                  </span>
                </th>
                <th>
                  <span class="flex items-center text-gray-800 dark:text-white">
                    Create / Update
                  </span>
                </th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @include('dashboard.layoutsDash.modals')
  @push('script')
    <script>
      function showDatatables() {
        let minDate, maxDate;

        // Initialize DataTable
        let table = $('#table-dayoff').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          "lengthMenu": [15, 25, 50, 75, 100, -1],
          ajax: {
            url: "dayoff",
            data: function(d) {
              d.dayoff = $('#dayoff-for').val();
              d.kode_pegawai = $('#kode-pegawai').val();
              d.status = $('#status').val();
              d.start = $('#datepicker-range-start').val();
              d.end = $('#datepicker-range-end').val();
            }
          },
          columns: [{
              data: "DT_RowIndex",
              name: "DT_RowIndex",
              searchable: false,
              orderable: false,
            },
            {
              data: 'null',
              name: 'action',
              render: function(data, type, row) {
                return `<div class="inline-flex" role="group">
												<a href="dayoff/${row.id}" class="mx-1 text-md font-medium rounded-lg focus:z-10">
													👁 <span class="hover:underline text-blue-500"> Show </span>
												</a>
												<a href="dayoff/${row.id}/edit"class="mx-1 text-md font-medium rounded-lg focus:z-10">
													&#9999; <span class="hover:underline text-green-500"> Edit </span>
												</a>
												@can('dayoff-delete')

												<a href="javascript:void(0)" id="delete-btn" data-id="${row.id}" data-url="{{ route('dayoff.destroy', ':id') }}" class="mx-1 text-md font-medium rounded-lg focus:z-10">
													&#x26D4; <span class="hover:underline text-red-500"> Delete </span>
												</a>
												@endcan
											</div>`;
              }
            },
            {
              data: 'id_nama_user',
              name: 'id_nama_user'
            },
            {
              data: 'dayoff_for',
              name: 'dayoff_for'
            },
            {
              data: 'tgl_dari',
              name: 'tgl_dari'
            },
            {
              data: 'tgl_hingga',
              name: 'tgl_hingga'
            },
            {
              data: 'statuses',
              name: 'statuses'
            },
            {
              data: 'created_updated_at',
              name: 'created_updated_at'
            }
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

        $('#cari').click(function() {
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
        $('#clear').click(function() {
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
      // end datatables //

      function deleteModal() {
        $("body").on("click", "#delete-btn", function() {
          let id = $(this).data("id");
          let url = $(this).data("url").replace(":id", id);
          let token = $("meta[name='csrf-token']").attr("content");

          Swal.fire({
            title: "Apakah Kamu Yakin?",
            text: "Ingin menghapus data ini!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Tidak",
            confirmButtonText: "Ya, Hapus!"
          }).then((result) => {
            if (result.isConfirmed) {
              // fetch data to ajax
              $.ajax({
                url: url,
                type: "DELETE",
                cache: false,
                data: {
                  "_token": token
                },
                success: function(response) {
                  Swal.fire({
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000
                  });

                  $('#table-dayoff').DataTable().ajax.reload(null, false);
                }
              })
            }
          })
        })
      }
      // end delete modal //

      $(document).ready(function() {
        showDatatables();
        deleteModal();
      });
    </script>
  @endpush
@endsection
