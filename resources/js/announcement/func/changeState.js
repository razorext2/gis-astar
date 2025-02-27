import { showAlert } from "../../utils/alert";

export function changeState() {
  $('body').on('click', '#state-btn', async function () {
    let id = $(this).data('id');

    const { value: state } = await Swal.fire({
      title: 'Ubah status',
      input: 'select',
      inputOptions: {
        0: 'Tidak aktif',
        1: 'Aktif',
      },
      inputPlaceholder: 'Pilih status',
      allowOutsideClick: false,
      showCancelButton: true,
      confirmButtonText: 'Ubah',
      cancelButtonText: 'Batal',
      preConfirm: (value) => {
        if (!value) {
          Swal.showValidationMessage('Status harus dipilih!');
          return false;
        }
      },
    });

    if (state) {
      const stateText = $('#swal2-select option:selected').text();

      const result = await Swal.fire({
        title: 'Apakah kamu yakin ingin mengubah status?',
        html: `Status akan berubah menjadi <b>${stateText}</b>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak',
      });

      if (result.isConfirmed) {
        try {
          const response = await axios.patch(`${APP_URL}/api/announcement-api/${id}/state`, {
            state,
          }, {
            validateStatus: () => true,
          });

          if (response.data.success) {
            showAlert('success', response.data.message);
            Livewire.dispatch('pg:eventRefresh-AnnouncementTable');
          } else {
            showAlert('error', response.data.message ?? 'Terjadi kesalahan saat mengubah status');
          }
        } catch (error) {
          showAlert('error', 'Terjadi kesalahan.', error.message);
        }
      }
    }
  });
}