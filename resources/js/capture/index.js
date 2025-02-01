// Constants
const R = 6371000; // Radius of Earth in meters
const lokasiSpan = document.getElementById('lokasi'); // Get the span element

// State variables
let lastLat, lastLng;

// Initialize the application
$(document).ready(function () {
    // Check if geolocation is supported
    if (navigator.geolocation) {
        // Start watching the user's position
        navigator.geolocation.watchPosition(handleSuccess, handleError, {
            enableHighAccuracy: true,
            timeout: 1000,
            maximumAge: 0,
        });
    } else {
        // Handle the case where geolocation is not supported
        showAlert("Gagal!", "Browser anda tidak memiliki support Geolocation.");
    }
});

// Handle the success case for geolocation
function handleSuccess(position) {
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    lokasiSpan.innerHTML = `${lat}, ${lng}`;

    // Calculate the distance from the specified location
    const distance = calculateDistance(SPECIFIED_LAT, SPECIFIED_LNG, lat, lng);

    // Check if the user is within the allowed radius
    if (distance > RADIUS) {
        // Handle the case where the user is outside the allowed radius
        showAlert("Gagal!", `Anda berada ${distance.toFixed(2)} meter dari tempat yang ditentukan.`);
        disableStartButton(); // Disable the button on failure
    } else if (lastLat !== undefined && lastLng !== undefined) {
        // Calculate the distance moved by the user
        const movedDistance = calculateDistance(lastLat, lastLng, lat, lng);

        // Check if the user has moved more than the allowed threshold
        if (movedDistance > MOVEMENT_THRESHOLD) {
            // Handle the case where the user has moved too far
            showAlert("Gagal!", "Fake GPS terdeteksi. Silahkan matikan terlebih dahulu.");
            disableStartButton(); // Disable the button on failure
            return;
        }
    } else {
        // Enable the start button
        enableStartButton();
        lastLat = lat;
        lastLng = lng;
    }
}

// Handle the error case for geolocation
function handleError(error) {
    // Handle different types of errors
    switch (error.code) {
        case error.PERMISSION_DENIED:
            showAlert("Gagal!", "Anda harus mengaktifkan izin Lokasi.");
            break;
        case error.POSITION_UNAVAILABLE:
            showAlert("Gagal!", "Posisi tidak tersedia.");
            break;
        case error.TIMEOUT:
            showAlert("Gagal!", "Permintaan lokasi telah timeout.");
            break;
        case error.UNKNOWN_ERROR:
            showAlert("Gagal!", "Terjadi kesalahan yang tidak diketahui.");
            break;
    }

    // Disable the start button
    disableStartButton();
}

// Show an alert to the user
function showAlert(title, message) {
    Swal.fire({
        title: title,
        html: message,
        timer: 1500,
        icon: "error",
        showConfirmButton: false,
    }).then(() => {
        pegawaiKosong.style.display = "block";
        pegawaiInfo.style.display = "none";
    });
}

// Disable the start button
function disableStartButton() {
    document.getElementById('startButton').disabled = true;
}

// Enable the start button
function enableStartButton() {
    document.getElementById('startButton').disabled = false;
}

// Calculate the distance between two points on the Earth's surface
function calculateDistance(lat1, lng1, lat2, lng2) {
    const dLat = (lat2 - lat1) * (Math.PI / 180);
    const dLng = (lng2 - lng1) * (Math.PI / 180);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
        Math.sin(dLng / 2) * Math.sin(dLng / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // Distance in meters
}
