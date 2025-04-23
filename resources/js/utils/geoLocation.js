export async function getLocation(mode = 'collect') {
  if (!navigator.geolocation) {
    throw new Error("Browser tidak mendukung Geolocation.");
  }

  const geoOptions = {
    enableHighAccuracy: true,
    timeout: 10000,
    maximumAge: 0,
  };

  const saveToLocalStorage = (coords) => {
    localStorage.setItem('longitude', coords.longitude);
    localStorage.setItem('latitude', coords.latitude);
  };

  const fallbackToLocalStorage = () => {
    const longitude = localStorage.getItem('longitude');
    const latitude = localStorage.getItem('latitude');
    if (longitude && latitude) {
      return {
        longitude,
        latitude,
        from: 'localStorage'
      };
    }
    throw new Error("Gagal mendapatkan lokasi dari localStorage.");
  };

  const getCurrentPositionPromise = () => {
    return new Promise((resolve, reject) => {
      navigator.geolocation.getCurrentPosition(resolve, reject, geoOptions);
    });
  };

  let attempts = 0;
  const maxAttempts = 3;

  while (attempts < maxAttempts) {
    try {
      const position = await getCurrentPositionPromise();
      const coords = {
        longitude: position.coords.longitude,
        latitude: position.coords.latitude,
        from: 'gps'
      };
      saveToLocalStorage(coords);
      return coords;
    } catch (error) {
      attempts++;
      // Handle specific geolocation errors
      if (error.code === error.PERMISSION_DENIED) {
        throw new Error("Akses lokasi ditolak. Harap aktifkan GPS dan izinkan akses lokasi, kemudian reload halaman ini.");
      } else if (error.code === error.POSITION_UNAVAILABLE) {
        throw new Error("Lokasi tidak dapat diakses, periksa sinyal atau pengaturan GPS.");
      } else if (error.code === error.TIMEOUT) {
        throw new Error("Pengambilan lokasi memakan waktu terlalu lama. Coba lagi.");
      }

      // Jika sudah mencoba maksimal, fallback ke localStorage
      if (attempts >= maxAttempts) {
        return fallbackToLocalStorage();
      }

      // Delay retry jika tidak berhasil
      await new Promise(res => setTimeout(res, 3000)); // Delay retry
    }
  }
}
