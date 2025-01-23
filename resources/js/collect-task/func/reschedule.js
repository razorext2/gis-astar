import { showAlert } from "../../utils/alert";

/**
 * @function reschedule
 * @description Fungsi untuk reschedule tagihan dengan kode xxxx
 * @param {void} 
 * @return {void}
 */
export function reschedule() {
  $('body').on('click', '#reschedule-btn', async function () {
    let id = $(this).data("id");

    const { value: confirmed } = await Swal.fire({
      icon: 'info',
      title: 'Apakah kamu yakin?',
      text: 'Ingin reschedule tagihan dengan kode xxxx?',
      showCancelButton: true,
      cancelButtonText: 'Tidak',
      confirmButtonText: 'Ya, Reschedule!'
    });

    if (confirmed) {
      const { value: date } = await Swal.fire({
        title: 'Ubah ke tanggal berapa?',
        input: 'date',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        didOpen: () => {
          const lastWeek = new Date();
          lastWeek.setDate(lastWeek.getDate() - 3);
          Swal.getInput().min = lastWeek.toISOString().split("T")[0];
        },
        preConfirm: (value) => {
          if (!value) {
            Swal.showValidationMessage("Tanggal tidak boleh kosong!");
            return false;
          }
        }
      });

      if (date) {
        try {
          const response = await axios.patch(`${APP_URL}/api/collect-task-api/${id}/reschedule`, {
            date: date,
            id: id,
          });

          if (response.data.success) {
            showAlert('success', response.data.message);
            $('#dataTable').DataTable().ajax.reload(null, false);
          } else {
            console.error(response.data.message);
            showAlert('error', response.data.message, response.data.data);
          }
        } catch (error) {
          console.log(error);
          showAlert('error', 'Ada kegagalan pada server.', error.message)
        }
      }
    }
  });
}

