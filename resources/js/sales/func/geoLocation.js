export function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.watchPosition(
      function (position) {
        $('#longitude').val(position.coords.longitude);
        $('#latitude').val(position.coords.latitude);
      },
      function () {
        window.Swal.fire({
          title: "Gagal!",
          html: "Anda harus mengaktifkan izin lokasi.",
          timer: 1500,
          icon: "error",
          showConfirmButton: false,
        }).then(() => setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect`, 1000));
      }
    );
  } else {
    window.Swal.fire({
      title: "Gagal!",
      html: "Browser anda tidak memiliki support Geolocation.",
      timer: 1500,
      icon: "error",
      showConfirmButton: false,
    }).then(() => setTimeout(() => window.location.href = `${APP_URL}/dashboard/collect`, 1000));
  }
}
