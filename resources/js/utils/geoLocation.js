export function getLocation() {
  if (navigator.geolocation) {
    // Opsi agar lebih cepat
    const geoOptions = {
      enableHighAccuracy: true, // false = lebih cepat, true = lebih akurat tapi lebih lambat
      timeout: 5000,             // 5 detik timeout
      maximumAge: 60000          // gunakan cache lokasi hingga 60 detik jika ada
    };

    // Coba dapatkan posisi satu kali, lebih cepat
    navigator.geolocation.getCurrentPosition(
      function (position) {
        $('#longitude').val(position.coords.longitude);
        $('#latitude').val(position.coords.latitude);
      },
      function () {
        window.Swal.fire({
          title: "Gagal!",
          html: "Anda harus mengaktifkan izin lokasi.",
          timer: 2000,
          icon: "error",
          showConfirmButton: false,
        }).then(() => setTimeout(() => window.location.href = `${APP_URL}/dashboard/sales`, 500));
      },
      geoOptions
    );

    // Jika ingin terus update lokasi, bisa aktifkan watchPosition juga (opsional)
    // navigator.geolocation.watchPosition(successCallback, errorCallback, geoOptions);
  } else {
    window.Swal.fire({
      title: "Gagal!",
      html: "Browser anda tidak memiliki support Geolocation.",
      timer: 2000,
      icon: "error",
      showConfirmButton: false,
    }).then(() => setTimeout(() => window.location.href = `${APP_URL}/dashboard/sales`, 500));
  }
}