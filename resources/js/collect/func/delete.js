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
        $.ajax({
          url: `${APP_URL}/api/collect-api/${id}`,
          type: "DELETE",
          cache: false,
          data: {
            "_token": token
          },
          success: function (response) {
            Swal.fire({
              icon: "success",
              title: response.message,
              showConfirmButton: false,
              timer: 1000
            });

            $('#dataTable').DataTable().ajax.reload(null, false);
          }
        })
      }
    })
  })
}
