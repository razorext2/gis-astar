export function addDataHandler() {
   $('body').on('click', '#add-button', async function() {

    const { value: newAnnouncement } = await Swal.fire({
      title: 'Tambah Pengumuman',
      html: `
        <form id="announcementForm" class="grid gap-4 !text-left">
          <div class="col-span-2">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul</label>
            <input type="text" name="title" id="title" class="swal2-input !w-full !m-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5" placeholder="Ketik judul...">
          </div>
                    
          <div class="col-span-2">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
            <textarea name="description" id="description" class="swal2-textarea !w-full !m-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" rows="4" placeholder="Tulis deskripsi..."></textarea>                    
          </div>
        </form>
      `,
      focusConfirm: false,
      confirmButtonText: 'Simpan',
      showCancelButton: true,
      cancelButtonText: 'Batal',
      didOpen: () => {
        $('#title').focus();
      },
      preConfirm: () => {
        const $form = $('#announcementForm');
        const title = $form.find('#title').val();
        const description = $form.find('#description').val();
        
        if (!title.trim()) {
          Swal.showValidationMessage('Judul harus diisi!');
          return false;
        }

        if (!description.trim()) {
          Swal.showValidationMessage('Deskripsi harus diisi!');
          return false;
        }

        return { title, description };
      }
    });

    if (newAnnouncement) {
      try {
        axios.post(`${APP_URL}/api/announcement-api`, newAnnouncement)
        .then(response => {
          Swal.fire({
            icon: "success",
            title: "Pengumuman berhasil ditambahkan!",
            showConfirmButton: false,
            timer: 1000
          });

          $('#dataTable').DataTable().ajax.reload(null, false);
        })
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Terjadi kesalahan",
          text: error.message,
        });
      }
    }

  });
}