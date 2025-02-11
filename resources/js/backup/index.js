import * as alert from "../utils/alert";

$(function () {
  showData();
  deleteData();
  newBackupHandler()
});

function showData() {
  let table = $("#dataTable").DataTable({
    "serverSide": true,
    "processing": true,
    "responsive": true,
    "lengthMenu": [10, 25, 50, 75, 100, -1],
    "searching": false,
    "ordering": false,
    ajax: {
      url: `${APP_URL}/dashboard/backup`,
      type: "GET",
    },
    columns: [{
      data: "actions",
      name: "actions",
    }, {
      data: "name",
      name: "name"
    }, {
      data: "type",
      name: "type"
    }, {
      data: "status",
      name: "status"
    }, {
      data: "created_at",
      name: "created_at"
    }, {
      data: "user_id",
      name: "user_id"
    }
    ],
    dom: `<"text-left lg:text-right dark:text-white"l><"relative overflow-x-auto w-full mt-20 lg:mt-4"t><"grid text-center gap-6 lg:grid-cols-2 mt-4 dark:text-white"<"lg:mt-3 lg:text-left"i><"lg:text-right dark:text-gray-900"p>>`,
    createdRow: function (row) {
      $(row).addClass('border-b-[0.5px] h-14 dark:border-gray-800 border-gray-200 hover:bg-gray-50 dark:hover:bg-[#222226]');
    }
  });
}

function newBackupHandler() {
  $('#new-backup').on('click', async function () {
    try {
      const response = await axios.post(`${APP_URL}/dashboard/backup`);

      if (!response.data.success) {
        return alert.showAlert('error', response.data.message, response.data.data);
      }

      alert.showAlert('success', response.data.message, response.data.data);
      $('#dataTable').DataTable().ajax.reload(null, false);
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

        alert.showAlert('success', response.data.message, response.data.data);
        $('#dataTable').DataTable().ajax.reload(null, false);
      } catch (error) {
        return alert.showAlert('error', 'Terjadi kesalahan.', error.message);
      }

    }
  });
}