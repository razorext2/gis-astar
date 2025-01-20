import { DataTable } from "simple-datatables";
import Swal from "sweetalert2";

/**
 * @function reschedule
 * @description Fungsi untuk reschedule tagihan dengan kode xxxx
 * @param {void} 
 * @return {void}
 */
export function reschedule() {
  $('body').on('click', '#reschedule-btn', async function () {
    let id = $(this).data("id");
    let token = $("meta[name='csrf-token']").attr("content");

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
          axios.patch(`${APP_URL}/api/collect-task-api/${id}/reschedule`, {
            date: date,
            id: id,
            _token: token
          }).then(response => {
            Swal.fire({
              icon: "success",
              title: "Tagihan berhasil direschedule!",
              showConfirmButton: false,
              timer: 1000
            });

            $('#dataTable').DataTable().ajax.reload(null, false);
          }).catch(error => {
            console.log(error);
            Swal.fire({
              icon: "error",
              title: "Ada kegagalan pada server.",
              text: error,
              showConfirmButton: false,
              timer: 1000
            })
          });
        } catch (error) {
          console.log(error);
          Swal.fire({
            icon: "error",
            title: "Ada kegagalan pada server.",
            text: error,
            showConfirmButton: false,
            timer: 1000
          });
        }
      }
    }
  });
}

