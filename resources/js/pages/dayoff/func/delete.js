import { showAlert, loadingAlert } from '../../../utils/alert';

export function deleteData() {
  $("body").on("click", "#delete-btn", function () {
    let id = $(this).data("id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
      title: "Apakah Kamu Yakin?",
      text: "Ingin menghapus data ini!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Tidak",
      confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
      if (result.isConfirmed) {
        loadingAlert("Menghapus data...");
        // fetch data to ajax
        axios.delete(`${APP_URL}/api/dayoff-api/${id}`, {
          data: {
            "_token": token
          }
        })
          .then(response => {
            Swal.close();
            showAlert('success', response.data.message);
            $('#table-dayoff').DataTable().ajax.reload(null, false);
          })
          .catch(error => {
            Swal.close();
            console.error('Error:', error);
            return showAlert('error', 'Terjadi kesalahan.', error.message);
          })
      }
    })
  })
}