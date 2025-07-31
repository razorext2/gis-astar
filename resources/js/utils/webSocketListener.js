import { showToast, showAlert } from "./alert";
import { handleNotification, handleAnnouncement } from "./notificationListener";

export async function initWebSocketListener() {
  // define userID, ambil dari metatag user-id
  const userId = document.querySelector('meta[name="user-id"]');

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
      .listen('.driverNewReport', (data) => {
        handleNotification(data);
      })
      .listen('.recognitionEvent', (data) => {
        let message = data.message.split('.').slice(0, 2).join('. ') + (data.message.split('.').length > 2 ? '...' : '');

        showAlert(data.type, data.title, message)
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
}