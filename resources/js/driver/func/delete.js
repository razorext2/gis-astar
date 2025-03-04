import { showAlert } from "../../utils/alert";

export function deleteData() {
  $("body").on("click", "#delete-btn", function () {
    let id = $(this).data("id");

    console.log(`${APP_URL}/api/driver-api/${id}`);

    Swal.fire({
      title: "Apakah Kamu Yakin?",
      text: "Ingin menghapus data ini!",
      icon: "warning",
      showCancelButton: true,
      cancelButtonText: "Tidak",
      confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
      if (result.isConfirmed) {
        // fetch data to ajax
        axios.delete(`${APP_URL}/api/driver-api/${id}`)
          .then(response => {

            if (!response.data.success) {
              return showAlert('error', response.data.message, response.data.data)
            }

            Livewire.dispatch('pg:eventRefresh-DriverTable');
            showAlert('success', response.data.message, response.data.data)
          })
          .catch(error => {
            showAlert('error', error.message, error.data)
          });
      }
    })
  })
}
