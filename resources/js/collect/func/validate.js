export async function confirmAction() {
  $('body').on('click', '#confirm-btn', async function () { // Make the handler async to use await
    let id = $(this).data("id");
    let token = $("meta[name='csrf-token']").attr("content");

    // Display SweetAlert2 dialog
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

    // If the action is confirmed
    if (result.isConfirmed) {
      $.ajax({
        url: `${APP_URL}/api/collectors/${id}/confirm`,
        type: 'PATCH',
        cache: false,
        data: {
          "_token": token
        },
        success: function (response) {
          Swal.fire("Laporan berhasil diapprove!", "", "success");
          setTimeout(() => {
            window.location.href = `${APP_URL}/dashboard/collect`;
          }, 1000);
        },
        error: function () {
          Swal.fire("Ada kegagalan pada server.", "", "error");
        }
      });
    }
    // If the action is denied
    else if (result.isDenied) {
      const {
        value: text
      } = await Swal.fire({
        input: "textarea",
        title: "Tulis alasan penolakan",
        inputPlaceholder: "Type your message here...",
        inputAttributes: {
          "aria-label": "Type your message here"
        },
        showCancelButton: true
      });

      // If the user enters a message, you can display it or send it to the server
      if (text) {
        // For now, just display the message
        $.ajax({
          url: `${APP_URL}/api/collectors/${id}/deny`,
          type: 'PATCH',
          cache: false,
          data: {
            "_token": token,
            "notes": text // Send the message with the request
          },
          success: function (response) {
            Swal.fire("Laporan telah ditolak!", "", "error");
            setTimeout(() => {
              window.location.href = `${APP_URL}/dashboard/collect`;
            }, 1000);
          },
          error: function () {
            Swal.fire("Ada kegagalan pada server.", "", "error");
          }
        });
      } else {
        Swal.fire("Catatan harus diisi.	", "", "error");
      }
    }
  });
}
