import { showAlert, loadingAlert } from '../../../utils/alert';
import { handleFormErrors } from '../../../utils/handleFormErrors';

// Fungsi untuk melakukan assign tugas ke satu pegawai
export async function singleAssign() {
  $('body').on('click', "#assign-btn", async function () {
    let id = $(this).data("id");
    const assign_by = $('meta[name="user-id"]').attr('content');

    // Menampilkan dialog input untuk kode jari pegawai
    const { value: input } = await Swal.fire({
      input: "number",
      title: "Mau assign ke siapa?",
      inputPlaceholder: "Ketik kode jari...",
      inputAttributes: {
        "aria-label": "Ketik kode jari..."
      },
      showCancelButton: true,
      preConfirm: (value) => {
        if (!value) {
          Swal.showValidationMessage("Kode jari tidak boleh kosong!");
          return false;
        }
        return value;
      }
    });

    if (input) {
      loadingAlert("Assign penagihan...");
      try {
        // Mengirim permintaan assign ke server
        const response = await axios.patch(`${APP_URL}/api/collect-task-ppn-api/${id}/assign`, {
          assign_to: input,
          assign_by: assign_by
        })
        if (response.data.success) {
          // Jika berhasil, tampilkan pesan sukses dan perbarui tabel
          Swal.close();
          showAlert('success', response.data.message);
          $('#dataTable').DataTable().ajax.reload(null, false);
        } else {
          // Jika gagal, tampilkan pesan error
          Swal.close();
          showAlert('error', response.data.message);
        }
      } catch (error) {
        // Tangani error dari server
        Swal.close();
        console.error('Error:', error);
        return showAlert('error', 'Terjadi kesalahan.', error.message);
      }
    }
  })
}

// Fungsi untuk melakukan assign tugas secara massal
export function massAssign() {
  $('#store').click(async function (e) {
    e.preventDefault();

    // Inisialisasi variabel
    const $button = $(this);
    const form = $('#mass-assign');
    let kode_pegawai = $('#kode_pegawai').val();
    let inputs = form.find('input[name="sr_data[]"]');
    let sr_data = Array.from(inputs).map(input => input.value);

    // Nonaktifkan tombol untuk mencegah multiple submission
    $button.prop('disabled', true);

    try {
      // Kirim permintaan assign massal ke server
      const response = await axios.patch(`${APP_URL}/api/collect-task-ppn-api/mass-assign`, {
        kode_pegawai: kode_pegawai,
        sr_data: sr_data,
        assign_by: assign_by,
      });

      // Proses respons dari server
      if (response.data.success) {
        // Jika berhasil, tampilkan pesan sukses dan redirect
        showAlert('success', response.data.message);
        setTimeout(() => {
          window.location.href = `${APP_URL}/dashboard/collect-task-ppn`;
        }, 1500);
      } else {
        // Jika gagal, tampilkan pesan error dan tangani kesalahan form
        $button.prop('disabled', false);
        showAlert('error', response.data.message);
        handleFormErrors(response.data.data);
      }
    } catch (error) {
      // Tangani error dari server
      $button.prop('disabled', false);
      console.error('Error:', error);
      showAlert('error', 'Terjadi kesalahan.', error.message);
    }
  })
}