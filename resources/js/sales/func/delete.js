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
        // fetch data to ajax
        axios.delete(`${APP_URL}/api/sales-api/${id}`, {
          data: {
            "_token": token
          }
        })
          .then(response => {
            Swal.fire({
              icon: "success",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1000
            });

            $('#dataTable').DataTable().ajax.reload(null, false);
          })
          .catch(error => {
            console.log(error);

            Swal.fire({
              icon: "error",
              title: "Terjadi Kesalahan",
              text: error,
              showConfirmButton: false,
              timer: 1000
            });
          });
      }
    })
  })
}
