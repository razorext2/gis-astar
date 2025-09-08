import Swal from "sweetalert2";
import { showAlert, loadingAlert } from "../../../utils/alert";

async function sendRequest(url, data) {
  try {
    const response = await axios.patch(url, data);
    if (response.data.success) {
      Swal.close();
      showAlert("success", response.data.message, response.data.data);
      setTimeout(() => {
        window.location.href = `/dashboard/driver`;
      }, 1500);
    } else {
      Swal.close();
      showAlert("error", response.data.message, response.data.data);
    }
  } catch (error) {
    Swal.close();
    showAlert("error", "Terjadi kesalahan", error.message);
  }
}

export async function confirmAction() {
  $('body').on("click", "#confirm-btn", async function () {
    let id = $(this).data("id");
    let userID = $('meta[name="user-id"]').attr('content');

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
          loadingAlert("Mengapprove laporan...");
          await sendRequest(`/api/driver-api/${id}/confirm`, { user_id: userID });
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
            loadingAlert('Meminta revisi...');
            await sendRequest(`/api/driver-api/${id}/revision`, {
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
            loadingAlert('Menolak laporan...');
            await sendRequest(`/api/driver-api/${id}/deny`, {
              user_id: userID,
              notes: text,
            });
          }
        } else {
          Swal.close();
        }
      }
    } catch (error) {
      Swal.close();
      console.error("Terjadi kesalahan:", error);
      return showAlert('error', 'Terjadi kesalahan', error.message);
    }
  });
}
