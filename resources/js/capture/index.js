$(document).ready(function () {
    const lokasiSpan = document.getElementById('lokasi'); // Get the span element

    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(
            function (position) {
                lat = position.coords.latitude;
                lng = position.coords.longitude;

                // Display the latitude and longitude in the span
                lokasiSpan.innerHTML = `${lat}, ${lng}`;

                // Calculate distance from the specified point
                const distance = calculateDistance(specifiedLat, specifiedLng, lat, lng);

                // Check if within the specified radius
                if (distance > radius) {
                    Swal.fire({
                        title: "Gagal!",
                        html: `Anda berada ${distance.toFixed(2)} meter dari tempat yang ditentukan.`,
                        timer: 1500,
                        icon: "error",
                        showConfirmButton: false,
                    }).then(() => {
                        pegawaiKosong.style.display = "block";
                        pegawaiInfo.style.display = "none";

                        setTimeout(() => {
                            window.location.href = redirectUrl;
                        }, 1000);
                    });
                } else if (lastLat !== undefined && lastLng !== undefined) {
                    // Calculate distance moved since last position
                    const movedDistance = calculateDistance(lastLat, lastLng, lat, lng);

                    if (movedDistance > movementThreshold) {
                        Swal.fire({
                            title: "Gagal!",
                            html: `Fake GPS terdeteksi. Silahkan matikan terlebih dahulu.`,
                            timer: 1500,
                            icon: "error",
                            showConfirmButton: false,
                        }).then(() => {
                            pegawaiKosong.style.display = "block";
                            pegawaiInfo.style.display = "none";

                            setTimeout(() => {
                                window.location.href = redirectUrl;
                            }, 2000);
                        });
                        return;
                    }
                }

                // Save current position for the next check
                lastLat = lat;
                lastLng = lng;
            },

            function (error) {
                Swal.fire({
                    title: "Gagal!",
                    html: `Anda harus mengaktifkan izin Lokasi.`,
                    timer: 1500,
                    icon: "error",
                    showConfirmButton: false,
                }).then(() => {
                    pegawaiKosong.style.display = "block";
                    pegawaiInfo.style.display = "none";

                    $('#startButton').click(function () {
                        Swal.fire({
                            title: "Peringatan!",
                            html: 'Aktifkan izin lokasi terlebih dahulu.',
                            timer: 1500,
                            icon: "error",
                            showConfirmButton: false
                        })
                    })

                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 3000);
                });
            }, {
            enableHighAccuracy: true,
            timeout: 1000,
            maximumAge: 0,
        });
    } else {
        window.Swal.fire({
            title: "Gagal!",
            html: `Browser anda tidak memiliki support Geolocation.`,
            timer: 1500,
            icon: "error",
            showConfirmButton: false,
        }).then(() => {
            pegawaiKosong.style.display = "block";
            pegawaiInfo.style.display = "none";

            setTimeout(() => {
                window.location.href = `${APP_URL}/dashboard`;
            }, 1000);
        });
    }
});

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