export async function showData() {
  let table = await $('#dataTable').DataTable({
    processing: true,
    pageLength: 25,
    serverSide: true,
    responsive: true,
    lengthMenu: [10, 25, 50, 75, 100, -1],
    ajax: {
      url: `${APP_URL}/dashboard/sales`,
      type: "GET",
      data: function (d) {
        d.kode_pegawai = $('#kode_pegawai').val();
        d.title = $('#title').val();
        d.customer_name = $('#customer_name').val();
        d.status = $('#status').val();
        d.startDate = $('#datepicker-range-start').val();
        d.endDate = $('#datepicker-range-end').val();
        d.roles = $('#roles').val();
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
      $('#datepicker-range-end').val(),
      $('#roles').val()
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
      $('#datepicker-range-end').val(),
      $('#roles').val()
    ];

    // Clear filters
    if (filters.some(value => value !== '')) {
      $('#kode_pegawai').val('');
      $('#title').val('');
      $('#customer_name').val('');
      $('#status').val('');
      $('#datepicker-range-start').val('');
      $('#datepicker-range-end').val('');
      $('#roles').val('');
      table.draw();
    }
  });
}

export function confirmData() {
  $("body").on("click", "#confirm-btn", async function () {
    const id = $(this).data('id');
    const response = await axios.get(`${APP_URL}/api/sales-api/${id}`);

    if (!response.data.success) {
      return showAlert('error', response.data.message);
    }

    const row = response.data.data

    let noTelp = row.customer_telp;

    if (row.customer_telp.substr(0, 2) == '08') {
      noTelp = row.customer_telp.replace(/^08/, "628");
    }

    let url = APP_URL + row.photo_collect_relasi[0].photourl;

    try {
      const check = await fetch(url, { method: "HEAD" }); // Gunakan HEAD agar lebih ringan
      if (!check.ok) { // Cek status, bukan hanya status 200
        url = APP_URL + "/assets/img/noImage.webp";
      }
    } catch (error) {
      url = APP_URL + "/assets/img/noImage.webp"; // Jika terjadi error (misal, jaringan terputus)
    }

    const result = await Swal.fire({
      html: `
        <div class=" min-w-96 text-left">
          
          <div class="grid gap-1 md:grid-cols-2 text-left">
            <div
              class="col-span-2 flex flex-col items-start rounded-xl">
              <span class="font-semibold">Detail: </span>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1">
              <p class="text-sm text-gray-700">Kode Pegawai</p>
              <p class="text-gray-800 text-base font-medium ">
                ${row.kode_pegawai}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1">
              <p class="text-sm text-gray-700">Nama Pegawai</p>
              <p class="text-gray-800 text-base font-medium ">
                ${row.pegawai_relasi.full_name}
              </p>
            </div>

          <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1"">
              <p class="text-sm text-gray-700">Waktu Dibuat</p>
              <p class="text-gray-800 text-base font-medium ">
                ${new Date(row.created_at).toLocaleString('id-ID')}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1"">
              <p class="text-sm text-gray-700">Waktu Diupdate</p>
              <p class="text-gray-800 text-base font-medium ">
                ${new Date(row.updated_at).toLocaleString('id-ID')}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3">
              <p class="text-sm text-gray-700">Judul laporan</p>
              <p class="text-gray-800 text-base font-medium ">
                ${row.title}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3">
              <p class="text-sm text-gray-700">Customer</p>
              <p class="text-gray-800 text-base font-medium ">
                ${row.customer_name} (${noTelp})
              </p>
              <a class="text-gray-800 inline-flex text-base font-medium underline "
                href="https://api.whatsapp.com/send?phone=${noTelp}&text=Halo, %2A${row.title}%2A. %0A%0ASaya marketing dari %2APT. Indodacin Presisi Utama%2A. Saya ingin menghubungi Anda terkait pesanan atau layanan yang mungkin Anda butuhkan.%0A%0AJika ada pertanyaan atau ingin berdiskusi lebih lanjut, silakan balas pesan ini.%0A%0ATerima kasih!%F0%9F%98%8A"
                target="_blank">
                Chat customer
              </a>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3">
              <p class="text-sm text-gray-700">Lokasi checkpoint</p>
              <span class="text-gray-800 text-base font-medium ">${row.lokasi}</span>
              <span class="text-xs font-medium text-gray-400 text-left">
                <a class="inline-flex underline"
                  href="https://www.google.com/maps/@${row.latitude},${row.longitude},20m/" target="_blank">
                  ${row.latitude}, ${row.longitude}
                </a>
              </span>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3">
              <p class="mb-2 text-sm text-gray-700">Dokumentasi</p>
              <div class="relative mx-auto flex-none items-center gap-4 rounded-xl p-2">
                <img class="h-52 w-52 rounded-xl object-cover transition duration-300 ease-in-out hover:scale-[2]" id="documentations" src="${url}" alt="" onclick="javascript:void(0)" loading="lazy">
              </div>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1">
              <p class="text-sm text-gray-700">Keterangan</p>
              <p class="text-gray-800 text-base font-medium !">
                ${row.keterangan}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1">
              <p class="text-sm text-gray-700">Status</p>
              <p class="text-gray-800 pt-1.5 text-base font-medium " id="status">
                <span class="rounded-xl bg-yellow-100 px-4 py-2 text-sm font-medium text-yellow-800 ring-1 ring-gray-300">
                  Sedang diajukan.
                </span>
              </p>
            </div>
          </div>
			  </div>`,
      confirmButtonText: 'Konfirmasi',
      showDenyButton: true,
      denyButtonText: "Tolak",
      showCancelButton: true,
      cancelButtonText: "Batal",
    });

    if (result.isConfirmed) {
      axios.patch(`${APP_URL}/api/sales-api/${id}/confirm`, {
        id: id,
      })
        .then(function () {
          Swal.fire("Laporan berhasil diapprove!", "", "success");
          return $('#dataTable').DataTable().ajax.reload(null, false);
        })
        .catch(function (error) {
          return Swal.fire("ada kegagalan pada server.", `${error}`, "error");
        });
    } else if (result.isDenied) {
      const { value: text } = await Swal.fire({
        input: 'textarea',
        inputPlaceholder: 'Alasan penolakan...',
        inputAttributes: {
          'aria-label': 'Type your message here'
        },
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return 'Alasan penolakan tidak boleh kosong!';
          }
        }
      });

      if (text) {
        axios.patch(`${APP_URL}/api/sales-api/${id}/deny`, {
          id: id,
          notes: text,
        })
          .then(function () {
            Swal.fire("Laporan berhasil ditolak!", "", "success");
            return $('#dataTable').DataTable().ajax.reload(null, false);
          })
          .catch(function (error) {
            return Swal.fire("ada kegagalan pada server.", `${error}`, "error");
          });
      }
    }
  });
}