import { showAlert, loadingAlert } from "../../../utils/alert";

export function deleteData() {
  $("body").on("click", "#delete-btn", function () {
    let id = $(this).data("id");

    Swal.fire({
      title: "Apakah Kamu Yakin?",
      text: "Ingin menghapus data ini!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Tidak",
      confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
      if (result.isConfirmed) {
        loadingAlert('Menghapus data...');
        // fetch data to ajax
        axios.delete(`/api/sales-api/${id}`)
          .then(response => {
            Swal.close();
            showAlert('success', response.data.message);
            $('#dataTable').DataTable().ajax.reload(null, false);
          })
          .catch(error => {
            console.log(error);
            Swal.close();
            showAlert('error', 'Terjadi kesalahan.', error.message);
          });
      }
    })
  })
}
