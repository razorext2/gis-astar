import { showAlert } from "./../../utils/alert";

export function confirmModal() {
  $("body").off("click", "#confirm-btn").on("click", "#confirm-btn", async function () {
    const id = $(this).data('id');
    const userID = $(this).data('userid');
    const response = await axios.get(`${APP_URL}/api/driver-api/${id}`);

    if (!response.data.success) {
      return showAlert('error', response.data.message);
    }

    const row = response.data.data
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
                ${row.pegawai.full_name}
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
                <img class="h-52 w-52 rounded-xl object-cover transition duration-300 ease-in-out hover:scale-[2]" id="documentations" src="${APP_URL}${row.photo_collect[0].photourl}" alt="">
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
      axios.patch(`${APP_URL}/api/driver-api/${id}/confirm`, {
        id: id,
        user_id: userID,
      })
        .then(function () {
          Swal.fire("Laporan berhasil diapprove!", "", "success");
          return Livewire.dispatch('pg:eventRefresh-DriverTable');
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
        axios.patch(`${APP_URL}/api/driver-api/${id}/deny`, {
          id: id,
          user_id: userID,
          notes: text,
        })
          .then(function () {
            Swal.fire("Laporan berhasil ditolak!", "", "success");
            return Livewire.dispatch('pg:eventRefresh-DriverTable');
          })
          .catch(function (error) {
            return Swal.fire("ada kegagalan pada server.", `${error}`, "error");
          });
      }
    }
  });
}