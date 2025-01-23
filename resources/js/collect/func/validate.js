export async function confirmAction() {
  $('body').on('click', '#confirm-btn', async function () { // Make the handler async to use await
    let id = $(this).data("id");
    let userID = $(this).data("validateby");

    // Display SweetAlert2 dialog
    const result = await Swal.fire({
      title: "Konfirmasi",
      text: "Apakah kamu yakin ingin approve laporan ini?",
      icon: 'question',
      showCancelButton: true,
      showDenyButton: true,
      denyButtonText: "Tolak",
      confirmButtonText: "Konfirmasi",
    });

    // If the action is confirmed
    if (result.isConfirmed) {
      // make sure that the data is correct
      const validation = await Swal.fire({
        icon: 'warning',
        title: 'Apakah kamu yakin?',
        text: 'Kamu bisa memeriksa kembali laporan ini sebelum disetujui.',
        confirmButtonText: 'Konfirmasi saja',
        showCancelButton: true,
        cancelButtonText: "Saya ingin memeriksa kembali"
      })

      if (validation.isConfirmed) {
        try {
          const response = await axios.patch(`${APP_URL}/api/collect-api/${id}/confirm`, {
            user_id: userID,
          });

          if (response.data.success) {
            Swal.fire({
              icon: "success",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500,
            });
            setTimeout(() => {
              window.location.href = `${APP_URL}/dashboard/collect`;
            }, 1000);
          } else {
            Swal.fire({
              icon: "error",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500,
            });
          }
        } catch (error) {
          Swal.fire({
            icon: "error",
            title: error.message,
            showConfirmButton: false,
            timer: 1500,
          });
        }
      }
    } else if (result.isDenied) { // If the action is denied
      const {
        value: text
      } = await Swal.fire({
        input: "textarea",
        title: "Tulis alasan penolakan",
        inputPlaceholder: "Type your message here...",
        inputAttributes: {
          "aria-label": "Type your message here"
        },
        showCancelButton: true,
        preConfirm: (value) => {
          if (!value) {
            Swal.showValidationMessage("Catatan harus diisi!");
            return false;
          }
        }
      });

      // If the user enters a message, you can display it or send it to the server
      if (text) {
        // For now, just display the message
        try {
          const response = await axios.patch(`${APP_URL}/api/collect-api/${id}/deny`, {
            "_token": token,
            "user_id": userID,
            "notes": text // Send the message with the request
          });

          if (response.data.success) {
            Swal.fire({
              icon: "success",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect`, 1500);
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
            title: "Ada kegagalan pada server",
            text: error.message,
            showConfirmButton: false,
            timer: 1500
          });
        }
      }
    }
  });
}
