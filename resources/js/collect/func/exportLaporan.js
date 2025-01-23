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
      },
      preConfirm: (date) => {
        if (!date) {
          Swal.showValidationMessage("Tanggal tidak boleh kosong!");
          return false;
        }

        return date;
      }
    });

    if (date) {
      // Prompt the user to select the type of report
      const { value: reportStatus } = await Swal.fire({
        title: "Pilih jenis laporan",
        input: "select",
        inputOptions: {
          0: 'Belum Dilengkapi',
          1: 'Disetujui',
          2: 'Diajukan',
          3: 'Ditolak'
        },
        inputPlaceholder: 'Pilih status laporan',
        showCancelButton: true,
        preConfirm: (value) => {
          if (!value) {
            Swal.showValidationMessage("Status laporan harus dipilih!");
            return false;
          }

          return value;
        }
      });

      if (reportStatus) {
        try {
          const response = await axios.get(`${APP_URL}/export/collector/`, {
            params: {
              date,
              reportStatus,
            }
          });

          if (response.data.success) {
            Swal.fire({
              title: response.data.message,
              text: response.data.data,
              showConfirmButton: false,
              icon: "success",
              timer: 1500,
            });
          } else {
            Swal.fire({
              title: response.data.message,
              text: response.data.data,
              showConfirmButton: false,
              icon: "error",
              timer: 1500,
            });
          }
        } catch (error) {
          Swal.fire({
            title: error.message,
            showConfirmButton: false,
            icon: "error",
            timer: 1500,
          });
        }


      }
    }
  });
}