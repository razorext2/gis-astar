export function showModal(data) {
  return Swal.fire({
    html: `
        <div class=" min-w-96 text-left">
          
          <div class="grid gap-1 md:grid-cols-2 text-left">
            <div
              class="col-span-2 flex flex-col items-start rounded-xl">
              <span class="font-semibold">Details: </span>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1">
              <p class="text-sm text-gray-700">Kode Pegawai</p>
              <p class="text-gray-800 text-base font-medium ">
                ${data.kode_pegawai}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1">
              <p class="text-sm text-gray-700">Nama Pegawai</p>
              <p class="text-gray-800 text-base font-medium ">
                ${data.pegawai.full_name}
              </p>
            </div>

          <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1"">
              <p class="text-sm text-gray-700">Waktu Dibuat</p>
              <p class="text-gray-800 text-base font-medium ">
                ${new Date(data.created_at).toLocaleString('id-ID')}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1"">
              <p class="text-sm text-gray-700">Waktu Diupdate</p>
              <p class="text-gray-800 text-base font-medium ">
                ${new Date(data.updated_at).toLocaleString('id-ID')}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3">
              <p class="text-sm text-gray-700">Judul laporan</p>
              <p class="text-gray-800 text-base font-medium ">
                ${data.title}
              </p>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3">
              <p class="text-sm text-gray-700">Lokasi checkpoint</p>
              <span class="text-gray-800 text-base font-medium ">${data.lokasi}</span>
              <span class="text-xs font-medium text-gray-400 text-left">
                <a class="inline-flex underline"
                  href="https://www.google.com/maps/search/?api=1&query=${data.latitude},${data.longitude}" target="_blank">
                  ${data.latitude}, ${data.longitude}
                </a>
              </span>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3">
              <p class="mb-2 text-sm text-gray-700">Dokumentasi</p>
              <div class="relative mx-auto flex-none items-center gap-4 rounded-xl p-2">
                <img class="h-52 w-52 rounded-xl object-cover transition duration-300 ease-in-out hover:scale-[2]" id="documentations" onerror="this.onerror=null; this.src='/assets/img/noImage.webp';" src="${data.photo_collect[0].photourl}" alt="">
              </div>
            </div>

            <div
              class="col-span-2 flex flex-col items-start rounded-xl border border-gray-200 bg-gray-50 p-3 lg:col-span-1">
              <p class="text-sm text-gray-700">Keterangan</p>
              <p class="text-gray-800 text-base font-medium !">
                ${data.keterangan}
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
}