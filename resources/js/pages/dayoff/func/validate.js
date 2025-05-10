import { showAlert, loadingAlert } from "../../../utils/alert";

export async function confirmAction() {
  $('body').on('click', '#confirm-btn', async function () { // Make the handler async to use await
    let id = $(this).data("id");
    let validate_by = $("meta[name='user-id']").attr("content");

    // Display SweetAlert2 dialog
    const result = await Swal.fire({
      title: "Konfirmasi",
      text: "Apakah kamu yakin ingin approve permohonan ini?",
      icon: 'info',
      showCancelButton: true,
      showDenyButton: true,
      denyButtonText: "Tolak",
      cancelButtonText: "Batal",
      confirmButtonText: "Ya",
    });

    // If the action is confirmed
    if (result.isConfirmed) {
      loadingAlert("Mengapprove permohonan...");
      await axios.patch(`${APP_URL}/api/dayoff-api/${id}/approve`, {
        'validate_by': validate_by
      }).then(() => {
        Swal.close();
        showAlert('success', 'Laporan berhasil diapprove!');
        setTimeout(() => {
          window.location.href = `${APP_URL}/dashboard/dayoff`;
        }, 1000);
      }).catch(() => {
        Swal.close();
        showAlert('error', 'Ada kegagalan pada server.');
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
        loadingAlert("Menolak permohonan...");
        // For now, just display the message
        await axios.patch(`${APP_URL}/api/dayoff-api/${id}/deny`, {
          'validate_by': validate_by,
          'notes': text
        }).then(() => {
          Swal.close();
          showAlert('success', 'Permohonan telah ditolak!');
          setTimeout(() => {
            window.location.href = `${APP_URL}/dashboard/dayoff`;
          }, 1000);
        }).catch(() => {
          Swal.close();
          showAlert('error', 'Ada kegagalan pada server.');
        });
      } else {
        showAlert('error', 'Catatan harus diisi.');
      }
    }
  });
}