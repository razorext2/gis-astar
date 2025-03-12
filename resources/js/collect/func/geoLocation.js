export function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(
      function (position) {
        $('#longitude').val(position.coords.longitude);
        $('#latitude').val(position.coords.latitude);
      },
      function () {
        Swal.fire({
          title: "Gagal!",
          text: "Anda harus mengaktifkan izin lokasi.",
          timer: 2000,
          icon: "error",
          showConfirmButton: false,
        }).then(() => setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect`, 500));
      }
    );
  } else {
    Swal.fire({
      title: "Gagal!",
      text: "Browser anda tidak memiliki support Geolocation.",
      timer: 2000,
      icon: "error",
      showConfirmButton: false,
    }).then(() => setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect`, 500));
  }
}
