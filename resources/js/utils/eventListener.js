import { showAlert } from "./alert";
import { showModal as showModalDriver } from "../pages/driver/func/modal";

export async function initEventListener() {
  // swal deletion prompt
  const confirmationModal = (title, html, icon) => {
    return Swal.fire({
      title: title,
      html: html,
      icon: icon,
      showCancelButton: true,
      confirmButtonText: "Ya. "
    });
  };

  // livewire confirm delete
  Livewire.on('confirmDelete', data => {
    confirmationModal(
      "Apa kamu yakin?",
      `Kamu akan menghapus data dengan ID <b>${data.id}</b>`,
      "warning"
    ).then((result) => {
      if (result.isConfirmed) {
        Livewire.dispatch('confirmDeleteAction', {
          id: data.id
        });
      }
    });
  });

  // livewire bulk delete event
  Livewire.on('confirmBulkDelete', data => {
    confirmationModal(
      "Apa kamu yakin?",
      `Kamu akan menghapus data dengan ID <b>${data.id}</b>`,
      "warning"
    ).then((result) => {
      if (result.isConfirmed) {
        Livewire.dispatch(`confirmBulkDeleteAction.${data.tableName}`, {
          id: data.id
        });
      }
    });
  })

  // livewire swal event
  Livewire.on('swal', data => {
    showAlert(data.icon, data.title, data.text)
  });

  // livewire redirect delayea
  Livewire.on('redirectRoute', route => {
    if (document.getElementById('dataTable')) {
      $('#dataTable').DataTable().ajax.reload();

      console.log('ada');
    } else {

      console.log('ga ada');
      setTimeout(() => {
        window.location.href = route;
      }, 1000);
    }
  })

  // livewire modal event
  Livewire.on('detailDriverModal', data => {
    showModalDriver(data.data).then(async (result) => {
      if (result.isConfirmed) {
        Livewire.dispatch('confirmAction', {
          id: data.data.id,
        });
      } else if (result.isDenied) {
        const revision = await Swal.fire({
          icon: "question",
          title: "Tolak laporan ini?",
          html: "Kamu dapat memberikan revisi sebanyak <b>1x</b> sebelum laporan ditolak.",
          confirmButtonText: "Revisi",
          showCancelButton: true,
          showDenyButton: true,
          denyButtonText: "Ya, Tolak!",
        });

        if (revision.isConfirmed) {
          const { value: reason } = await Swal.fire({
            title: 'Alasan penolakan',
            input: 'textarea',
            inputPlaceholder: 'Alasan penolakan...',
            inputAttributes: {
              'aria-label': 'Type your message here'
            },
            showCancelButton: true,
            inputValidator: (value) => {
              if (!value) {
                return 'Alasan penolakan tidak boleh kosong!';
              }
            }
          });

          if (reason) {
            Livewire.dispatch('revisionAction', {
              id: data.data.id,
              note: reason
            });
          }
        } else if (revision.isDenied) {
          const { value: reason } = await Swal.fire({
            title: 'Alasan penolakan',
            input: 'textarea',
            inputPlaceholder: 'Alasan penolakan...',
            inputAttributes: {
              'aria-label': 'Type your message here'
            },
            showCancelButton: true,
            inputValidator: (value) => {
              if (!value) {
                return 'Alasan penolakan tidak boleh kosong!';
              }
            }
          });

          if (reason) {
            Livewire.dispatch('declineAction', {
              id: data.data.id,
              note: reason
            });
          }
        } else {
          Swal.close();
        }
      }
    });
  });

  Livewire.on('confirmation', data => {
    console.log(data);

    confirmationModal(
      "Apa kamu yakin?",
      `Kamu akan memverifikasi kehadiran dengan ID <b>${data.id}</b>`,
      "warning",
    ).then((result) => {
      if (result.isConfirmed) {
        Livewire.dispatch(`${data.action}.${data.tableName}`, {
          id: data.id,
          tableName: data.tableName,
        });
      }
    });
  })
}