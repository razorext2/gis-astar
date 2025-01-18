export function getAttendanceData() {
  $('[data-popover-trigger="click"]').on('click', async function () {
    const date = $(this).data('date');
    const popoverContent = $(`#popover-click-${date} .popover-content`);

    // Mengambil data menggunakan Axios
    await axios.get(`${APP_URL}/api/get-attendance-data`, {
      params: {
        date: date, // Ambil dari data-date
        id: id, // Ambil dari Blade
        period: '2024-12',
      }
    })
      .then(function (response) {
        const data = response.data;

        // Membuat tabel untuk data kehadiran
        let attendanceTable = `
					<table class="min-w-full text-gray-800 divide-y divide-gray-200 dark:text-white dark:divide-gray-500">
						<thead class="bg-gray-100 dark:bg-gray-700">
							<tr>
								<th class="px-4 py-2 text-left rounded-tl-lg">ID</th>
								<th class="px-4 py-2 text-left">Jam Masuk</th>
								<th class="px-4 py-2 text-left rounded-tr-lg">Foto</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-200 dark:bg-gray-600 dark:divide-gray-500">`;

        data.attendance.forEach(item => {
          const jamMasuk = new Date(item.jam_masuk);
          const formattedjamMasuk = jamMasuk.toLocaleTimeString(
            'id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
          });

          const photoURL = libs; // Ambil dari Blade
          const url = item.photoURL; // URL dari item
          const path =
            `${APP_URL}/${photoURL}/${url}.png`; // Gabungkan URL

          attendanceTable += `
							<tr>
								<td class="px-4 py-2">${item.id}</td>
								<td class="px-4 py-2">${formattedjamMasuk}</td>
								<td class="px-4 py-2"><img src="${path}" alt="Foto" class="object-cover w-16 h-16 rounded-lg"></td>
							</tr>`;
        });

        attendanceTable += `
						</tbody>
					</table>`;

        // Membuat tabel untuk data keluar
        let attendanceOutTable = `
					<table class="min-w-full text-gray-800 divide-y divide-gray-200 dark:text-white dark:divide-gray-500">
						<thead class="bg-gray-100 dark:bg-gray-700">
							<tr>
								<th class="px-4 py-2 text-left">ID</th>
								<th class="px-4 py-2 text-left">Jam Keluar</th>
								<th class="px-4 py-2 text-left">Foto</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-200 dark:bg-gray-600 dark:divide-gray-500">`;
        data.attendanceOut.forEach(item => {
          const jamKeluar = new Date(item.jam_keluar);
          const formattedjamKeluar = jamKeluar.toLocaleTimeString(
            'id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
          });

          const photoURL = libs; // Ambil dari Blade
          const url = item.photoURL; // URL dari item
          const path =
            `${APP_URL}/${photoURL}/${url}.png`; // Gabungkan URL

          attendanceOutTable += `
							<tr>
								<td class="px-4 py-2">${item.id}</td>
								<td class="px-4 py-2">${formattedjamKeluar}</td>
								<td class="px-4 py-2"><img src="${path}" alt="Foto" class="object-cover w-16 h-16 rounded-lg"></td>
							</tr>`;
        });

        attendanceOutTable += `
						</tbody>
						<tfooter>
							<tr>
								<th class="px-4 py-2 text-left bg-gray-100 rounded-bl-lg dark:bg-gray-700"></th>
								<th class="px-4 py-2 text-left bg-gray-100 dark:bg-gray-700"></th>
								<th class="px-4 py-2 text-left bg-gray-100 rounded-br-lg dark:bg-gray-700"></th>
							</tr>
						</tfooter>
					</table>`;

        // Memperbarui konten popover dengan tabel
        popoverContent.html(`
						${attendanceTable}
						${attendanceOutTable}
					`);
      })
      .catch(function (error) {
        console.error('Error fetching data:', error);
        popoverContent.html('<p>Terjadi kesalahan saat memuat data.</p>');
      });
  });
}