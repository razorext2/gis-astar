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
    }).then(async (result) => {
      if (result.isConfirmed) {
        // fetch data to ajax
        try {
          const response = await axios.delete(`${APP_URL}/api/collect-api/${id}`);

          if (response.data.success) {
            Swal.fire({
              icon: "success",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500
            });

            $('#dataTable').DataTable().ajax.reload(null, false);
          } else {
            Swal.fire({
              icon: "error",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500
            });
          }
        } catch (error) {
          Swal.fire({
            icon: "error",
            title: error.message,
            showConfirmButton: false,
            timer: 1500
          });
        }
      }
    })
  })
}
