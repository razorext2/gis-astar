import { showData } from "./func/showData";
import { deleteData } from "./func/delete";
import { showAlert } from "../utils/alert";

$(document).ready(function () {
  showData();
  deleteData();

  $("body").on("click", "#confirm-btn", async function () {
    const id = $(this).data('id');
    const response = await axios.get(`${APP_URL}/api/sales-api/${id}`);

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
                ${row.customer_name}
              </p>
              <a class="text-gray-800 inline-flex text-base font-medium underline "
                href="https://api.whatsapp.com/send?phone=${row.customer_telp}&text=Halo, %2A${row.title}%2A. %0A%0ASaya %2A${userName}%2A, marketing dari %2APT. Indodacin Presisi Utama%2A. Saya ingin menghubungi Anda terkait pesanan atau layanan yang mungkin Anda butuhkan.%0A%0AJika ada pertanyaan atau ingin berdiskusi lebih lanjut, silakan balas pesan ini.%0A%0ATerima kasih!%F0%9F%98%8A"
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
                <img class="h-52 w-52 rounded-xl object-cover transition duration-300 ease-in-out hover:scale-[2]" id="documentations" data-url="${row.photo_collect_relasi[0].photourl}" src="${row.photo_collect_relasi[0].photourl}" alt="" onclick="javascript:void(0)" loading="lazy">
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
        user_id: userID,
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
          user_id: userID,
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
})