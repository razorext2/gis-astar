import { showAlert } from "../../../utils/alert";

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
      loadingAlert("Menghapus data...");
      try {
        const response = await axios.delete(`/api/collect-idy-ppn-api/${id}`);

        if (response.data.success) {
          Swal.close();
          showAlert('success', response.data.message);
          $('#dataTable').DataTable().ajax.reload(null, false);
        } else {
          Swal.close();
          showAlert('error', response.data.message);
        }
      } catch (error) {
        Swal.close();
        console.error('Error:', error);
        return showAlert('error', 'Terjadi kesalahan.', error.message);
      }
    }
  });
}
