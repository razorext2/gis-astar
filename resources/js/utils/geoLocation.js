export async function getLocation(mode = 'collect') {
  if (!navigator.geolocation) {
    throw new Error("Browser tidak mendukung Geolocation.");
  }

  // Opsi dengan tingkat akurasi tinggi dan timeout yang cukup
  const geoOptions = {
    enableHighAccuracy: true,
    timeout: 10000, // Turunkan sedikit timeout-nya agar retry lebih agresif 
    maximumAge: 0,
  };

  // Simpan data koordinat ke local storage beserta timestamp kapan diambil
  const saveToLocalStorage = (coords) => {
    localStorage.setItem('longitude', coords.longitude);
    localStorage.setItem('latitude', coords.latitude);
    localStorage.setItem('geo_timestamp', Date.now().toString());
  };

  // Mekanisme pertahanan jika GPS error berkali-kali menggunakan cache lokasi
  const fallbackToLocalStorage = () => {
    const longitude = localStorage.getItem('longitude');
    const latitude = localStorage.getItem('latitude');
    const timestampStr = localStorage.getItem('geo_timestamp');
    
    if (longitude && latitude && timestampStr) {
      const timestamp = parseInt(timestampStr, 10);
      const isExpired = (Date.now() - timestamp) > (5 * 60 * 1000); // Kedaluwarsa dalam 5 menit

      if (!isExpired) {
        console.warn("[GeoLocation] GPS gagal, fallback ke data lokasi terakhir kali (cached).");
        return {
          longitude,
          latitude,
          from: 'localStorage_cached'
        };
      } else {
        throw new Error("Sinyal GPS gagal dan cache lokasi sudah kedaluwarsa. Silakan keluar ruangan agar sinyal membaik.");
      }
    }

    throw new Error("Sinyal GPS tidak ditemukan dan tidak ada data lokasi sebelumnya.");
  };

  const getCurrentPositionPromise = () => {
    return new Promise((resolve, reject) => {
      navigator.geolocation.getCurrentPosition(resolve, reject, geoOptions);
    });
  };

  let attempts = 0;
  const maxAttempts = 3; // Kurangi ke 3 agar user tidak menunggu terlalu lama jika benar-benar blank spot

  while (attempts < maxAttempts) {
    attempts++;
    try {
      const position = await getCurrentPositionPromise();
      const coords = {
        longitude: position.coords.longitude,
        latitude: position.coords.latitude,
        from: 'gps_live'
      };

      // Sukses ambil GPS live, simpan ke memori sebagai backup
      saveToLocalStorage(coords);
      return coords;

    } catch (error) {
      console.warn(`[GeoLocation] Percobaan ${attempts} gagal dengan kode: ${error.code}`);

      // 1: PERMISSION_DENIED - User sengaja menolak, JANGAN di-retry
      if (error.code === 1) { // 1 is GeolocationPositionError.PERMISSION_DENIED
        throw new Error("Anda menolak akses lokasi. Harap izinkan akses lokasi pada browser untuk melanjutkan absen.");
      } 

      // 2: POSITION_UNAVAILABLE atau 3: TIMEOUT - Sinyal lemah, boleh di-retry
      if (attempts >= maxAttempts) {
        // Coba pakai fallback setelah mencapai batas maksimal kegagalan
        return fallbackToLocalStorage();
      }

      // Jeda sekitar 1.5 detik sebelum mencoba GPS kembali
      await new Promise(res => setTimeout(res, 1500));
    }
  }
}
