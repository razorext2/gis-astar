import $ from "jquery";
import "./bootstrap";
import "flowbite";
import Swal from "sweetalert2";
import { handleNotification, handleAnnouncement, fetchNotification } from './notification';
import { showToast, showAlert } from './utils/alert';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid'

window.$ = window.jQuery = $;

document.addEventListener('livewire:navigated', function () {
  fetchNotification();

  // define userID, ambil dari metatag user-id
  const userId = document.querySelector('meta[name="user-id"]');

  // define swal sebagai global variable  
  window.Swal = Swal;

  const confirmDelete = (data) => {
    return Swal.fire({
      title: "Apa kamu yakin?",
      html: `Kamu akan menghapus data dengan ID <b>${data.id}</b>`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!"
    });
  };

  if (userId) {
    // define Echo sebagai global variable
    window.Echo.private(`notifications.${userId.content}`)
      .listen('.exportCompleted', (data) => {
        console.log(data);
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
        console.log(data);
        showToast('success', 'Cadangan berhasil dibuat.');
        Livewire.dispatch('pg:eventRefresh-BackupTable');
      });

    window.Echo.private(`announcements.${userId.content}`)
      .listen('.newAnnouncement', (data) => {
        console.log(data);
        handleAnnouncement(data);
      });
  }

  Livewire.on('confirmDelete', data => {
    confirmDelete(data).then((result) => {
      if (result.isConfirmed) {
        Livewire.dispatch('confirmDeleteAction', {
          logId: data.id
        });
      }
    });
  });

  Livewire.on('confirmBulkDelete', data => {
    confirmDelete(data).then((result) => {
      if (result.isConfirmed) {
        Livewire.dispatch(`confirmBulkDeleteAction.${data.tableName}`, {
          logId: data.id
        });
      }
    });
  })

  Livewire.on('swal', data => {
    showAlert(data.icon, data.title, data.text)
  });
});