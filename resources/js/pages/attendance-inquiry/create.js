import { getLocation } from '../../utils/geoLocation';
import { loadingAlert, showAlert } from '../../utils/alert';

async function initCreateGeo() {
  const container = document.getElementById('attendance-inquiry-create-container');
  if (!container) {
    return;
  }

  window.dispatchEvent(new CustomEvent('gps-loading'));

  try {
    loadingAlert("Mengambil lokasi...");
    
    // Call the existing utility geoLocation helper
    const coords = await getLocation('driver');
    
    if (window.Livewire) {
      const componentId = container.getAttribute('wire:id');
      const component = Livewire.find(componentId);
      if (component) {
        component.set('longitude', String(coords.longitude));
        component.set('latitude', String(coords.latitude));
        
        window.dispatchEvent(new CustomEvent('gps-success', {
          detail: { latitude: coords.latitude, longitude: coords.longitude }
        }));
      }
    }
    Swal.close();
  } catch (err) {
    Swal.close();
    showAlert('error', 'Gagal mengambil lokasi', err.message);
    window.dispatchEvent(new CustomEvent('gps-failed', {
      detail: { error: err.message }
    }));
  }
}

// Global function to trigger scanning from view/Alpine
window.triggerGeoScan = initCreateGeo;

document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById('attendance-inquiry-create-container')) {
    initCreateGeo();
  }
});

document.addEventListener("livewire:navigated", () => {
  if (document.getElementById('attendance-inquiry-create-container')) {
    initCreateGeo();
  }
});
