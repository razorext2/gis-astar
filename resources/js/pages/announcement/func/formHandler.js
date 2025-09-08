import { showAlert } from "../../../utils/alert";

export function addDataHandler() {
  $('body').on('click', '#add-button', async function () {

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
        axios.post(`/api/announcement-api`, newAnnouncement)
          .then(response => {
            showAlert('success', response.data.message);
            Livewire.dispatch('pg:eventRefresh-AnnouncementTable')
          })
      } catch (error) {
        showAlert('error', 'Terjadi kesalahan.', error.message);
      }
    }

  });
}

export function editDataHandler() {
  $('body').on('click', '#edit-btn', async function () {

    let id = $(this).data('id');

    const response = await axios.get(`/api/announcement-api/${id}`);

    if (response.data.success) {
      const data = response.data.data;

      const { value: updateAnnouncement } = await Swal.fire({
        title: 'Ubah Data',
        html:
          `
          <form id="announcementForm" class="grid gap-4 !text-left">
            <div class="col-span-2">
              <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Judul</label>
              <input type="text" name="title" id="title" class="swal2-input !w-full !m-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 p-2.5" placeholder="Ketik judul..." value="${data.title}">
            </div>

            <div class="col-span-2">
              <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
              <textarea name="description" id="description" class="swal2-textarea !w-full !m-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" rows="4" placeholder="Tulis deskripsi...">${data.description}</textarea>
            </div>
          </form>
          `,
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ubah',
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

      if (updateAnnouncement) {
        try {

          const response = await axios.patch(`/api/announcement-api/${id}`, updateAnnouncement);

          if (response.data.success) {
            showAlert('success', response.data.message);
            Livewire.dispatch('pg:eventRefresh-AnnouncementTable');
          } else {
            showAlert('error', response.data.message);
          }

        } catch (error) {
          console.error(error);
          showAlert('error', 'Terjadi kesalahan.', error.message);
        }
      }
    } else {
      console.error(response.data.message);
      showAlert('error', response.data.message, response.data.data);
    }
  });
}