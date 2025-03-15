import { showAlert } from '../../utils/alert';

let geoWatcher = null; // Simpan ID watcher

export async function initCapture() {
    let lastLat, lastLng, lat, lng;

    // Hapus watcher lama jika ada
    if (geoWatcher !== null) {
        navigator.geolocation.clearWatch(geoWatcher);
    }

    const lokasiSpan = document.getElementById('lokasi'); // Get the span element
    const specifiedLat = parseFloat(document.getElementById('specifiedLat').value);
    const specifiedLng = parseFloat(document.getElementById('specifiedLng').value);
    const radius = parseFloat(document.getElementById('radius').value);
    const movementThreshold = parseFloat(document.getElementById('movementThreshold').value);

    if (navigator.geolocation) {
        geoWatcher = navigator.geolocation.watchPosition(
            function (position) {
                lat = position.coords.latitude;
                lng = position.coords.longitude;

                // Display the latitude and longitude in the span
                lokasiSpan.innerHTML = `${lat}, ${lng}`;

                // Calculate distance from the specified point
                const distance = calculateDistance(specifiedLat, specifiedLng, lat, lng);

                // Check if within the specified radius
                if (distance > radius) {
                    showErrorAndRedirect(`Anda berada ${distance.toFixed(2)} meter dari tempat yang ditentukan.`);
                } else if (lastLat !== undefined && lastLng !== undefined) {
                    // Calculate distance moved since last position
                    const movedDistance = calculateDistance(lastLat, lastLng, lat, lng);

                    if (movedDistance > movementThreshold) {
                        showErrorAndRedirect("Fake GPS terdeteksi. Silahkan matikan terlebih dahulu.");
                        return;
                    }
                }

                // Save current position for the next check
                lastLat = lat;
                lastLng = lng;
            },
            function () {
                showErrorAndRedirect("Anda harus mengaktifkan izin Lokasi.");
            }, {
            enableHighAccuracy: true,
            timeout: 1000,
            maximumAge: 0,
        }
        );
    } else {
        showErrorAndRedirect("Browser anda tidak memiliki support Geolocation.");
    }

    // Function to calculate distance between two coordinates using Haversine formula
    function calculateDistance(lat1, lng1, lat2, lng2) {
        const R = 6371000; // Radius of Earth in meters
        const dLat = (lat2 - lat1) * (Math.PI / 180);
        const dLng = (lng2 - lng1) * (Math.PI / 180);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
            Math.sin(dLng / 2) * Math.sin(dLng / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distance in meters
    }

    function showErrorAndRedirect(message) {

        showAlert("error", "Gagal!", message).then(() => {
            pegawaiKosong.style.display = "block";
            pegawaiInfo.style.display = "none";
            setTimeout(() => {
                window.location.href = `${APP_URL}/dashboard/capture`;
            }, 500);
        });
    }
}
