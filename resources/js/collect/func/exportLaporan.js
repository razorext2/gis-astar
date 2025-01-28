import { showAlert } from "../../utils/alert";

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
        const { value: type } = await Swal.fire({
          input: "select",
          title: "Pilih tipe tagihan",
          inputOptions: {
            'idcnonppn': 'IDC Non PPn',
            'idcppn': 'IDC PPn',
          },
          inputPlaceholder: 'Pilih tipe tagihan',
          showCancelButton: true,
          preConfirm: (value) => {
            if (!value) {
              Swal.showValidationMessage("Tipe tagihan harus dipilih!");
              return false;
            }

          }
        })

        if (type) {
          try {
            const response = await axios.get(`${APP_URL}/export/collector/`, {
              params: {
                date,
                reportStatus,
                type,
              }
            });

            if (response.data.success) {
              showAlert('success', response.data.message, response.data.data);
            } else {
              showAlert('success', response.data.message, response.data.data);
            }
          } catch (error) {
            showAlert('error', error.message, null);
          }
        }

      }
    }
  });
}