import { showAlert } from '../../../utils/alert';

export async function validate() {
  $('body').on('click', '#confirm-btn', async function () {
    let id = $(this).data("id");
    const validate_by = $('meta[name="user-id"]').attr('content');

    const result = await Swal.fire({
      title: "Konfirmasi",
      text: "Apakah kamu yakin ingin menutup tagihan ini?",
      icon: "info",
      showCancelButton: true,
      showDenyButton: false,
      cancelButtonText: "Batal",
    });

    if (result.isConfirmed) {
      try {
        const response = await axios.patch(`${APP_URL}/api/collect-task-ppn-api/${id}/validate`, { validate_by: validate_by });

        if (response.data.success) {
          showAlert('success', response.data.message);
          setTimeout(() => window.location.reload(), 1000);
        } else {
          showAlert('error', response.data.message, response.data.data);
        }
      } catch (error) {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan.', error.message);
      }
    }
  });
}