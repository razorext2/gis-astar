import { showAlert } from "../../../utils/alert";

/**
 * Handles the export functionality for the report.
 * Prompts the user to select a date and report type, then exports the report.
 */
export function exportHandler() {
    $(".getCollectorExcel").click(async function () {
        // Prompt the user to select a date for the report
        const { value: exportData } = await Swal.fire({
            title: "Sesuaikan filter",
            html: `
        <form id="formExport" class="grid gap-4 !text-left">
          <div class="col-span-2">
            <label for="tglLaporan" class="block mb-2 text-sm font-medium text-gray-900">Tanggal laporan</label>
            <input id="tglLaporan" type="date" class="bg-gray-50 border border-zinc-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Select date">
          </div>

          <div class="col-span-2">
            <label for="statusLaporan" class="block mb-2 text-sm font-medium text-gray-900">Status laporan</label>
            <select id="statusLaporan" class="bg-gray-50 border border-zinc-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
              <option value="">Pilih</option>
              <option value="0">Belum Dilengkapi</option>
              <option value="1">Disetujui</option>
              <option value="2">Diajukan</option>
              <option value="3">Ditolak</option>
            </select>
          </div>

          <div class="col-span-2">
            <label for="tipeTagihan" class="block mb-2 text-sm font-medium text-gray-900">Tipe tagihan</label>
            <select id="tipeTagihan" class="bg-gray-50 border border-zinc-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
              <option value="">Pilih</option>
              <option value="idcnonppn">IDC Non PPn</option>
              <option value="idcppn">IDC PPn</option>
              <option value="idyppn">IDY PPn</option>
            </select>
          </div>
        </form>
      `,
            focusConfirm: false,
            confirmButtonText: "Export",
            showCancelButton: true,
            cancelButtonText: "Batal",
            didOpen: () => {
                $("#tglLaporan").focus();
            },
            preConfirm: () => {
                const $form = $("#formExport");
                const date = $form.find("#tglLaporan").val().trim();
                const reportStatus = $form.find("#statusLaporan").val().trim();
                const type = $form.find("#tipeTagihan").val().trim();

                if (!date) {
                    Swal.showValidationMessage("Tanggal laporan harus diisi!");
                    return false;
                }

                if (!reportStatus) {
                    Swal.showValidationMessage("Status laporan harus diisi!");
                    return false;
                }

                if (!type) {
                    Swal.showValidationMessage("Tipe tagihan harus diisi!");
                    return false;
                }

                return { date, reportStatus, type };
            },
        });

        if (exportData) {
            try {
                const response = await axios.get(`/export/collector/`, {
                    params: exportData,
                });

                if (response.data.success) {
                    showAlert("success", response.data.message);
                } else {
                    showAlert("error", response.data.message);
                }
            } catch (error) {
                showAlert("error", "Terjadi kesalahan.", error.message);
            }
        }
    });
}
