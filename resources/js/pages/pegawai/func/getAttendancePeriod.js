export function getAttendancePeriod() {
  let attendancePeriodsCache = null; // Cache untuk data periode

  $('#getAttendancePeriod').click(async function () {
    try {
      const inputOptions = attendancePeriodsCache || await axios.get(`/api/getSixMonthsBefore`)
        .then(response => {
          if (!response.data.success) {
            throw new Error('Data tidak valid.');
          }
          // Transformasi data menjadi inputOptions
          const options = response.data.data.reduce((options, item) => {
            options[item.value] = item.label;
            return options;
          }, {});
          // Simpan ke cache
          attendancePeriodsCache = options;
          return options;
        })
        .catch(error => {
          console.error('Error fetching periods:', error);
          Swal.fire('Error', 'Gagal memuat periode. Coba lagi nanti.', 'error');
          throw error;
        });

      const { value: period } = await Swal.fire({
        title: "Pilih periode",
        input: "select",
        showCancelButton: true,
        inputPlaceholder: "Pilih periode",
        inputOptions: inputOptions,
        inputValidator: (value) => {
          if (!value) {
            return "Periode tidak boleh kosong.";
          }
        }
      });

      if (period) {
        // Arahkan pengguna ke URL dengan parameter periode
        window.location.href = `/dashboard/pegawai/${ids}/detail?period=${period}`;
      }
    } catch (error) {
      console.error('Error during period selection:', error);
    }
  });
}