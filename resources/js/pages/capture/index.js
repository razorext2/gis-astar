import { showAlert, loadingAlert } from "../../utils/alert";

let geoWatcher = null; // Simpan ID watcher

export function initCapture() {
    let selfDetectLoaded = false;

    // Hapus watcher lama jika ada
    if (geoWatcher !== null) {
        navigator.geolocation.clearWatch(geoWatcher);
    }

    const lokasiSpan = document.getElementById("lokasi");
    const specifiedLatEl = document.getElementById("specifiedLat");
    const specifiedLngEl = document.getElementById("specifiedLng");
    const radiusEl = document.getElementById("radius");

    // Pastikan elemen DOM yang dibutuhkan ada sebelum melanjutkan
    if (!lokasiSpan || !specifiedLatEl || !specifiedLngEl || !radiusEl) {
        console.warn(
            "Elemen untuk geolocation tidak ditemukan di DOM. Inisialisasi capture dibatalkan.",
        );
        return;
    }

    const specifiedLat = parseFloat(specifiedLatEl.value);
    const specifiedLng = parseFloat(specifiedLngEl.value);
    const radius = parseFloat(radiusEl.value);

    if (!navigator.geolocation) {
        return disableScannerUI(
            "Browser anda tidak memiliki support Geolocation.",
        );
    }

    // Tampilkan pesan loading
    loadingAlert("Mengambil lokasi...");

    geoWatcher = navigator.geolocation.watchPosition(
        function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Update UI lokasi
            lokasiSpan.innerHTML = `${lat}, ${lng}`;

            // Hitung jarak dari titik spesifik
            const distance = calculateDistance(
                specifiedLat,
                specifiedLng,
                lat,
                lng,
            );

            // Validasi radius
            if (distance > radius) {
                // Asumsi Swal tersedia secara global, gunakan .close() atau bisa buat closeAlert() di utilitas.
                if (window.Swal) Swal.close();

                showError(
                    `Anda harus berada didalam radius area yang ditentukan. Jika sudah, silahkan refresh kembali.`,
                );
                disableScannerUI(
                    `Anda berada ${distance.toFixed(2)} meter dari tempat yang ditentukan.`,
                );
                return;
            }

            // Jika lokasi valid dan belum diload
            if (lat !== null || lng !== null) {
                if (window.Swal) Swal.close();

                console.log("[System] Location verified:", lat, lng);

                // Call selfDetect (Lazy loading)
                if (!selfDetectLoaded) {
                    selfDetectLoaded = true;
                    import("./selfDetect.js")
                        .then((module) => {
                            module.initSelfDetect(lat, lng);
                        })
                        .catch((err) =>
                            console.error(
                                "Gagal memuat modul selfDetect:",
                                err,
                            ),
                        );
                }
            }
        },
        function (error) {
            if (window.Swal) Swal.close();

            let errorMessage = "Terjadi kesalahan saat mengambil lokasi.";
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage =
                        "Izin lokasi ditolak. Silakan aktifkan izin lokasi di pengaturan browser atau perangkat Anda.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage =
                        "Informasi lokasi tidak tersedia. Pastikan perangkat Anda tidak dalam mode pesawat dan memiliki koneksi GPS.";
                    break;
                case error.TIMEOUT:
                    errorMessage =
                        "Pengambilan lokasi terlalu lama. Pastikan sinyal GPS Anda kuat dan coba lagi.";
                    break;
            }

            showError(errorMessage);
            disableScannerUI(errorMessage);
        },
        {
            enableHighAccuracy: true,
            timeout: 60000,
            maximumAge: 0,
        },
    );

    // --- Helper Functions --- //

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    function calculateDistance(lat1, lng1, lat2, lng2) {
        const R = 6371000; // Radius of Earth in meters
        const dLat = (lat2 - lat1) * (Math.PI / 180);
        const dLng = (lng2 - lng1) * (Math.PI / 180);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * (Math.PI / 180)) *
                Math.cos(lat2 * (Math.PI / 180)) *
                Math.sin(dLng / 2) *
                Math.sin(dLng / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distance in meters
    }

    /**
     * Disable UI interactability when verification fails
     */
    function disableScannerUI(message) {
        showAlert("error", "Gagal!", message);

        const pegawaiKosong = document.getElementById("pegawaiKosong");
        if (pegawaiKosong) pegawaiKosong.style.display = "block";

        const startBtn = document.getElementById("startButton");
        if (startBtn) {
            startBtn.disabled = true;
            // Gunakan class turunan dari design system UI yang baru
            startBtn.classList.add(
                "opacity-50",
                "cursor-not-allowed",
                "grayscale",
            );
        }
    }

    /**
     * Show Error Message in the error box
     */
    function showError(message) {
        const container = document.getElementById("error");
        if (container) {
            container.textContent = message;
            container.classList.remove("hidden");
        }
    }
}
