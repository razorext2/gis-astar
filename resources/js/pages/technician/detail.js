import * as alert from '../../utils/alert';
import { zoomImage } from "../../utils/zoomImage";

document.addEventListener('DOMContentLoaded', () => {
  zoomImage();

  if (document.getElementById('store')) {
    validate();
  }
})

function validate() {
  document.getElementById('store').addEventListener('click', async () => {
    const id = document.getElementById('store').dataset.id;

    const result = await Swal.fire({
      title: "Konfirmasi?",
      text: "Apakah kamu yakin ingin mengkonfirmasi pekerjaan ini?",
      icon: "question",
      showCancelButton: true,
      showDenyButton: true,
      denyButtonText: "Tolak",
      cancelButtonText: "Batal",
      confirmButtonText: "Konfirmasi",
    });

    if (result.isConfirmed) {
      const confirm = await Swal.fire({
        title: "Konfirmasi",
        text: "Setelah laporan dikonfirmasi, data akan diupdate ke database sehingga perubahaan tidak mungkin dilakukan",
        icon: "info",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: "Ya, konfirmasi.",
        cancelButtonText: "Batalkan, masih ingin memeriksa",
      });

      if (!confirm.isConfirmed) {
        console.log('dicancel')
        return;
      }

      axios.patch(`${APP_URL}/api/technician/${id}/confirm`)
        .then((response) => {

          if (!response.data.success) {
            return alert.showAlert('error', response.data.message, response.data.data);
          }

          alert.showAlert('success', response.data.message, response.data.data);

          setTimeout(() => {
            window.location.reload();
          }, 1500);
        })
        .catch((error) => {
          alert.showAlert('error', 'Ada kegagalan pada server', error.data)
          console.log(error);
        });

    } else if (result.isDenied) {
      console.log('ditolak')

      const revision = await Swal.fire({
        icon: 'question',
        title: 'Penolakan atau Revisi?',
        html: 'Dibandingkan langsung <b>menolak laporan</b>, anda mungkin dapat mempertimbangkan untuk memberikan <b>revisi</b> terlebih dahulu.',
        showConfirmButton: true,
        confirmButtonText: 'Ya, minta revisi',
        showCancelButton: true,
        cancelButtonText: 'Saya ingin memeriksa kembali.',
        showDenyButton: true,
        denyButtonText: "Tidak, tolak laporan ."
      })

      if (revision.isConfirmed) {
        const { value: notes } = await Swal.fire({
          title: 'Alasan revisi',
          input: 'textarea',
          inputPlaceholder: 'Masukkan alasan revisi',
          showCancelButton: true,
          inputValidator: (value) => {
            if (!value) {
              return 'Alasan revisi tidak boleh kosong!';
            }
          }
        })

        if (notes) {
          axios.patch(`${APP_URL}/api/technician/${id}/revision`, {
            'note': notes
          }).then((response) => {
            if (!response.data.success) {
              return alert.showAlert('error', response.data.message, response.data.data);
            }

            alert.showAlert('success', response.data.message, response.data.data);

            setTimeout(() => {
              window.location.reload();
            }, 1500);
          }).catch((error) => {
            alert.showAlert('error', 'Ada kegagalan pada server', error.data)
            console.log(error);
          })
        }
      } else if (revision.isDenied) {
        const { value: notes } = await Swal.fire({
          title: 'Alasan penolakan',
          input: 'textarea',
          inputPlaceholder: 'Masukkan alasan penolakan',
          showCancelButton: true,
          inputValidator: (value) => {
            if (!value) {
              return 'Alasan penolakan tidak boleh kosong!';
            }
          }
        })

        if (notes) {
          axios.patch(`${APP_URL}/api/technician/${id}/deny`, {
            'note': notes
          }).then((response) => {
            if (!response.data.success) {
              return alert.showAlert('error', response.data.message, response.data.data);
            }

            alert.showAlert('success', response.data.message, response.data.data);

            setTimeout(() => {
              window.location.reload();
            }, 1500);
          }).catch((error) => {
            alert.showAlert('error', 'Ada kegagalan pada server', error.data)
            console.log(error);
          })
        }
      } else {
        Swal.close();
      }
    } else {
      Swal.close();
    }
  })
}
