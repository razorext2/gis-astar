import { showAlert, loadingAlert } from '../../utils/alert';

let geoWatcher = null; // Simpan ID watcher

export async function initCapture() {
    let lastLat, lastLng, lat, lng;
    let selfDetectLoaded = false;

    // Hapus watcher lama jika ada
    if (geoWatcher !== null) {
        navigator.geolocation.clearWatch(geoWatcher);
    }

    const lokasiSpan = document.getElementById('lokasi'); // Get the span element
    const specifiedLat = parseFloat(document.getElementById('specifiedLat').value);
    const specifiedLng = parseFloat(document.getElementById('specifiedLng').value);
    const radius = parseFloat(document.getElementById('radius').value);
    // const movementThreshold = parseFloat(document.getElementById('movementThreshold').value);

    if (navigator.geolocation) {
        // tampilkan loading message
        loadingAlert('Mengambil lokasi...');

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
                    Swal.close();
                    showErrorAndRedirect(`Anda berada ${distance.toFixed(2)} meter dari tempat yang ditentukan.`);
                    showError('Anda harus berada didalam radius area yang ditentukan. Jika sudah, silahkan refresh kembali.');
                    return
                }

                // else if (lastLat !== undefined && lastLng !== undefined) {
                //     // Calculate distance moved since last position
                //     const movedDistance = calculateDistance(lastLat, lastLng, lat, lng);

                //     if (movedDistance > movementThreshold) {
                //         showErrorAndRedirect("Fake GPS terdeteksi. Silahkan matikan terlebih dahulu.");
                //         showError('Matikan aplikas Fake GPS anda. Jika sudah, silahkan refresh kembali.');
                //         return;
                //     }
                // }

                if (lat !== null || lng !== null) {
                    Swal.close();

                    console.log('your location:', lat, lng);

                    // Call selfDetect here
                    if (!selfDetectLoaded) {
                        selfDetectLoaded = true;
                        import('./selfDetect.js').then((module) => {
                            module.initSelfDetect(lat, lng);
                        });
                    }
                };

                // Save current position for the next check
                lastLat = lat;
                lastLng = lng;
            },
            function (error) {
                Swal.close();

                let errorMessage = 'Terjadi kesalahan saat mengambil lokasi.';
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Izin lokasi ditolak. Silakan aktifkan izin lokasi di pengaturan browser atau perangkat Anda.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Informasi lokasi tidak tersedia. Pastikan perangkat Anda tidak dalam mode pesawat dan memiliki koneksi GPS.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Pengambilan lokasi terlalu lama. Pastikan sinyal GPS Anda kuat dan coba lagi.';
                        break;
                    default:
                        errorMessage = 'Terjadi kesalahan yang tidak diketahui saat mengambil lokasi.';
                        break;
                }

                showErrorAndRedirect(errorMessage);
                showError(errorMessage);
            }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0,
        });
    } else {
        Swal.close();
        return showErrorAndRedirect("Browser anda tidak memiliki support Geolocation.");
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
        const startBtn = document.getElementById('startButton');

        showAlert("error", "Gagal!", message)
        pegawaiKosong.style.display = "block";

        startBtn.disabled = true;
        startBtn.classList.add('bg-gray-500');
        startBtn.classList.remove('bg-blue-400', 'dark:bg-blue-800', 'dark:hover:bg-blue-900', 'hover:bg-blue-700');
    }

    function showError(message) {
        const container = document.getElementById('error');
        container.textContent = message;
        container.classList.remove('hidden');
    }
}
