import * as alert from "../utils/alert";

document.addEventListener('livewire:navigated', function () {
  deleteData();
  newBackupHandler()
});

function newBackupHandler() {
  $('#new-backup').on('click', async function () {
    try {
      const response = await axios.post(`${APP_URL}/dashboard/backup`);

      if (!response.data.success) {
        return alert.showAlert('error', response.data.message, response.data.data);
      }

      Livewire.dispatch('pg:eventRefresh-BackupTable');
      alert.showAlert('success', response.data.message, response.data.data);
    } catch (error) {
      return alert.showAlert('error', 'Terjadi kesalahan.', error.message);
    }
  });
}

function deleteData() {
  $('body').on('click', '#delete', async function () {
    const id = $(this).data('id');

    const ask = await Swal.fire({
      icon: 'question',
      title: 'Yakin ingin menghapus?',
      html: `Data dengan ID <b>${id}</b> akan terhapus. Ingin melanjutkan?`,
      showCancelButton: true,
      cancelButtonText: 'Tidak',
      confirmButtonText: 'Ya, Hapus!'
    })

    if (ask.isConfirmed) {

      try {
        const response = await axios.delete(`${APP_URL}/dashboard/backup/${id}`);

        if (!response.data.success) {
          return alert.showAlert('error', response.data.message, response.data.data);
        }

        Livewire.dispatch('pg:eventRefresh-BackupTable');
        alert.showAlert('success', response.data.message, response.data.data);
      } catch (error) {
        return alert.showAlert('error', 'Terjadi kesalahan.', error.message);
      }

    }
  });
}