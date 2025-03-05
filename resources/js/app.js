import $ from "jquery";
import "./bootstrap";
import "flowbite";
import Swal from "sweetalert2";
import { handleNotification, handleAnnouncement, fetchNotification } from './notification';
import { showToast, showAlert } from './utils/alert';
import { showModal } from "./utils/modal";
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';
import flatpickr from "flatpickr";

window.flatpickr = flatpickr;
window.$ = window.jQuery = $;

document.addEventListener('livewire:navigated', function () {
  fetchNotification();

  // define userID, ambil dari metatag user-id
  const userId = document.querySelector('meta[name="user-id"]');

  // define swal sebagai global variable  
  window.Swal = Swal;

  // websocket using echo and reverb
  if (userId) {
    // define Echo sebagai global variable
    window.Echo.private(`notifications.${userId.content}`)
      .listen('.exportCompleted', (data) => {
        handleNotification(data);
      })
      .listen('.newTaskAssigned', (data) => {
        handleNotification(data);
      })
      .listen('.collectorUpdatedReport', (data) => {
        handleNotification(data);
      })
      .listen('.salesNewReport', (data) => {
        handleNotification(data);
      })
      .listen('.backupReady', (data) => {
        showToast('success', data.message);
        Livewire.dispatch('pg:eventRefresh-BackupTable');
      });

    window.Echo.private(`announcements.${userId.content}`)
      .listen('.newAnnouncement', (data) => {
        handleAnnouncement(data);
      });
  }

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

});