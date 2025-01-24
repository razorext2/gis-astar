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

        const response = await axios.delete(`${APP_URL}/api/announcement-api/${id}`);

        if (response.data.success) {
          Swal.fire({
            icon: 'success',
            title: response.data.message,
            showConfirmButton: false,
            timer: 1000
          })

          $('#dataTable').DataTable().ajax.reload(null, false);

        } else {
          Swal.fire({
            icon: 'error',
            title: response.data.message,
            showConfirmButton: false,
            timer: 1000
          })
        }
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: error.message,
          showConfirmButton: false,
          timer: 1000
        })
      }
    }

  });
}