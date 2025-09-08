import { showAlert } from "../../../utils/alert";

export function deleteData() {
  $('body').on('click', '#delete-btn', async function () {
    let id = $(this).data('id');

    const result = await Swal.fire({
      title: 'Apakah kamu yakin?',
      text: 'Ingin menghapus data ini!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
    })

    if (result.isConfirmed) {
      try {
        if ($('#notification-alert').length) {
          setTimeout(() => {
            $('#notification-alert').remove();
          }, 1000);
        }

        const response = await axios.delete(`/api/announcement-api/${id}`);

        if (response.data.success) {
          showAlert('success', response.data.message);
          Livewire.dispatch('pg:eventRefresh-AnnouncementTable');
        } else {
          showAlert('error', response.data.message);
        }
      } catch (error) {
        showAlert('error', 'Terjadi kesalahan.', error.message);
      }
    }

  });
}