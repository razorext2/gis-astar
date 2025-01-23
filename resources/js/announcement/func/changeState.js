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
      inputValidator: function (value) {
        if (!value) {
          return 'Status harus diisi!';
        }
      }
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
            Swal.fire({
              icon: 'success',
              title: 'Sukses',
              text: 'Status berhasil diubah',
            });

            $('#dataTable').DataTable().ajax.reload(null, false);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Terjadi kesalahan',
              text: response.data.message ?? 'Terjadi kesalahan saat mengubah status',
            });
          }
        } catch (error) {
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan',
            text: error.message,
          });
        }
      }
    }
  });
}