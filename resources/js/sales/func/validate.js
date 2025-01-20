import { icon } from "leaflet";

export function confirmAction() {
  $('#confirm-btn').click(async function () {
    let id = $(this).data("id");
    let userID = $(this).data("validateby");
    let token = $("meta[name='csrf-token']").attr("content");

    const result = await Swal.fire({
      title: "Konfirmasi",
      text: "Apakah kamu yakin ingin approve laporan ini?",
      icon: 'info',
      showCancelButton: true,
      showDenyButton: true,
      denyButtonText: "Tolak",
      cancelButtonText: "Batal",
      confirmButtonText: "Ya",
    });

    if (result.isConfirmed) {
      axios.patch(`${APP_URL}/api/sales-api/${id}/confirm`, {
        id: id,
        user_id: userID,
        _token: token,
      })
        .then(function () {
          Swal.fire("Laporan berhasil diapprove!", "", "success");
          setTimeout(() => {
            window.location.href = `${APP_URL}/dashboard/sales`;
          }, 1000);
        })
        .catch(function (error) {
          Swal.fire("ada kegagalan pada server.", `${error}`, "error");
          console.log(error);
        });
    } else {
      const { value: text } = await Swal.fire({
        input: 'textarea',
        inputPlaceholder: 'Alasan penolakan...',
        inputAttributes: {
          'aria-label': 'Type your message here'
        },
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return 'Alasan penolakan tidak boleh kosong!';
          }
        }
      });

      if (text) {
        axios.patch(`${APP_URL}/api/sales-api/${id}/deny`, {
          id: id,
          user_id: userID,
          notes: text,
          _token: token,
        })
          .then(function () {
            Swal.fire("Laporan berhasil ditolak!", "", "success");
            setTimeout(() => {
              window.location.href = `${APP_URL}/dashboard/sales`;
            }, 1000);
          })
          .catch(function (error) {
            Swal.fire("ada kegagalan pada server.", `${error}`, "error");
            console.log(error);
          });
      }
    }
  });
}