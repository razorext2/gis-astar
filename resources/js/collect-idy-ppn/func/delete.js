import { showAlert } from "./../../utils/alert";

export function deleteData() {
  $("body").on("click", "#delete-btn", async function () {
    let id = $('#delete-btn').data("id");

    const result = await Swal.fire({
      title: "Apakah Kamu Yakin?",
      text: "Ingin menghapus data ini!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Tidak",
      confirmButtonText: "Ya, Hapus!"
    });

    if (result.isConfirmed) {
      try {
        const response = await axios.delete(`${APP_URL}/api/collect-idy-ppn-api/${id}`);

        if (response.data.success) {
          showAlert('success', response.data.message);
          $('#dataTable').DataTable().ajax.reload(null, false);
        } else {
          showAlert('error', response.data.message);
        }
      } catch (error) {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan.', error.message);
      }
    }
  });
}
