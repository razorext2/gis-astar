import Swal from "sweetalert2";

export async function validate() {
  $('body').on('click', '#confirm-btn', async function () {
    let id = $(this).data("id");
    let token = $("meta[name='csrf-token']").attr("content");

    const result = await Swal.fire({
      title: "Konfirmasi",
      text: "Apakah kamu yakin ingin menutup tagihan ini?",
      icon: "info",
      showCancelButton: true,
      showDenyButton: false,
      cancelButtonText: "Batal",
    });

    if (result.isConfirmed) {
      axios.patch(`${APP_URL}/api/collect-task-api/${id}/validate`, {
        validate_by: validate_by,
        _token: token,
      })
        .then(function () {
          Swal.fire({
            icon: "success",
            title: "Tagihan berhasil ditutup!",
            showConfirmButton: false,
            timer: 1000,
          })

          setTimeout(() => window.location.reload(), 1000);
        })
        .catch(function (error) {
          Swal.fire({
            icon: "error",
            title: "Ada kegagalan pada server. " + error
          })
        })
    }
  })
}