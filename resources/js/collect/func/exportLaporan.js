/**
 * Handles the export functionality for the report.
 * Prompts the user to select a date and report type, then exports the report.
 */
export function exportHandler() {
  $('.getCollectorExcel').click(async function () {
    // Prompt the user to select a date for the report
    const { value: date } = await Swal.fire({
      title: "Pilih tanggal laporan",
      showCancelButton: true,
      cancelButtonText: "Batal",
      input: "date",
      didOpen: () => {
        const lastWeek = new Date();
        lastWeek.setDate(lastWeek.getDate() - 3);
        Swal.getInput().min = lastWeek.toISOString().split("T")[0];
      }
    });

    if (date) {
      // Prompt the user to select the type of report
      const { value: reportStatus } = await Swal.fire({
        title: "Pilih jenis laporan",
        input: "select",
        inputOptions: {
          0: 'Belum Dilengkapi',
          1: 'Diajukan',
          2: 'Disetujui',
          3: 'Ditolak'
        },
        inputPlaceholder: 'Pilih status laporan',
        showCancelButton: true,
      });

      if (reportStatus) {
        // If both date and report type are selected, proceed with the export
        axios.get(`${APP_URL}/export/collector/`,
          {
            params: {
              date: date,
              status: reportStatus,
            }
          }
        )
          .then(function () {
            Swal.fire({
              title: "Berhasil, data kamu sedang diexport",
              icon: "success",
              timer: 1000,
            });
          })
          .catch(function (error) {
            Swal.fire({
              title: `Gagal`,
              text: error.message,
              icon: "error",
              timer: 1000,
            });
          });
      } else {
        // If report type is not selected, show an error message
        Swal.fire({
          title: 'Jenis laporan tidak boleh kosong!',
          icon: 'error',
          showConfirmButton: false,
          timer: 1000,
        });
      }
    }
  });
}