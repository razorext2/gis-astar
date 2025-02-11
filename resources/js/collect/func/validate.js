import { showAlert } from "../../utils/alert";

async function sendRequest(url, data) {
  try {
    const response = await axios.patch(url, data);
    if (response.data.success) {
      showAlert("success", response.data.message, response.data.data);
      setTimeout(() => {
        window.location.href = `${APP_URL}/dashboard/collect/submitted`;
      }, 1500);
    } else {
      showAlert("error", response.data.message, response.data.data);
    }
  } catch (error) {
    showAlert("error", "Terjadi kesalahan", error.message);
  }
}

export async function confirmAction() {
  $('body').on("click", "#confirm-btn", async function () {
    let id = $(this).data("id");
    let userID = $(this).data("validateby");

    try {
      // Dialog Konfirmasi
      const result = await Swal.fire({
        title: "Konfirmasi",
        text: "Apakah kamu yakin ingin approve laporan ini?",
        icon: "question",
        showCancelButton: true,
        showDenyButton: true,
        denyButtonText: "Tolak",
        confirmButtonText: "Konfirmasi",
      });

      if (result.isConfirmed) {
        const validation = await Swal.fire({
          icon: "warning",
          title: "Apakah kamu yakin?",
          text: "Kamu bisa memeriksa kembali laporan ini sebelum disetujui.",
          confirmButtonText: "Konfirmasi saja",
          showCancelButton: true,
          cancelButtonText: "Saya ingin memeriksa kembali",
        });

        if (validation.isConfirmed) {
          await sendRequest(`${APP_URL}/api/collect-api/${id}/confirm`, { user_id: userID });
        }
      } else if (result.isDenied) {
        const revision = await Swal.fire({
          icon: "question",
          title: "Tolak laporan ini?",
          html: "Kamu dapat memberikan revisi sebanyak <b>1x</b> sebelum laporan ditolak.",
          confirmButtonText: "Revisi",
          showCancelButton: true,
          showDenyButton: true,
          denyButtonText: "Ya, Tolak!",
        });

        if (revision.isConfirmed) {
          const { value: text } = await Swal.fire({
            input: "textarea",
            title: "Tulis alasan revisi",
            inputPlaceholder: "Type your message here...",
            inputAttributes: { "aria-label": "Type your message here" },
            showCancelButton: true,
            preConfirm: (value) => {
              if (!value) {
                Swal.showValidationMessage("Catatan harus diisi!");
                return false;
              }
            },
          });

          if (text) {
            await sendRequest(`${APP_URL}/api/collect-api/${id}/revision`, {
              user_id: userID,
              notes: text,
            });
          }
        } else if (revision.isDenied) {
          const { value: text } = await Swal.fire({
            input: "textarea",
            title: "Tulis alasan penolakan",
            inputPlaceholder: "Type your message here...",
            inputAttributes: { "aria-label": "Type your message here" },
            showCancelButton: true,
            preConfirm: (value) => {
              if (!value) {
                Swal.showValidationMessage("Catatan harus diisi!");
                return false;
              }
            },
          });

          if (text) {
            await sendRequest(`${APP_URL}/api/collect-api/${id}/deny`, {
              user_id: userID,
              notes: text,
            });
          }
        } else {
          Swal.close();
        }
      }
    } catch (error) {
      console.error("Terjadi kesalahan:", error);
    }
  });
}
