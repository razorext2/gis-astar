import { showAlert } from "./alert";
import { showModal } from "./modal";

export async function initEventListener() {
  // swal deletion prompt
  const confirmDelete = (data) => {
    return Swal.fire({
      title: "Apa kamu yakin?",
      html: `Kamu akan menghapus data dengan ID <b>${data.id}</b>`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!"
    });
  };

  // livewire confirm delete
  Livewire.on('confirmDelete', data => {
    confirmDelete(data).then((result) => {
      if (result.isConfirmed) {
        Livewire.dispatch('confirmDeleteAction', {
          id: data.id
        });
      }
    });
  });

  // livewire bulk delete event
  Livewire.on('confirmBulkDelete', data => {
    confirmDelete(data).then((result) => {
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

  // livewire modal event
  Livewire.on('detailModal', data => {
    showModal(data.data).then(async (result) => {
      if (result.isConfirmed) {
        Livewire.dispatch('confirmAction', {
          id: data.data.id,
          user_id: userId.content,
        });
      } else if (result.isDenied) {
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
          console.log(reason);
          Livewire.dispatch('declineAction', {
            id: data.data.id,
            user_id: userId.content,
            note: reason
          });
        }
      }
    });
  });
}