var rangeInput = document.getElementById('radius-input');
var currencyInput = document.getElementById('radius');

function updateCurrencyInput() {
  currencyInput.value = rangeInput.value;
}

rangeInput.addEventListener('input', updateCurrencyInput);

document.addEventListener('DOMContentLoaded', function () {
  // Fungsi untuk inisialisasi peta dengan koordinat yang diberikan
  function initializeMap(lat, lng) {
    var map = L.map('map').setView([lat, lng], 17); // Inisialisasi peta dengan koordinat yang didapat
    document.getElementById('longitude').value = lng;
    document.getElementById('latitude').value = lat;

    // Tambahkan tile layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var customIcon = L.icon({
      iconUrl: icon, // Ganti dengan path ke ikon Anda
      iconSize: [25, 41], // Ukuran ikon
      iconAnchor: [12, 41], // Titik untuk mengaitkan ikon ke koordinat
      shadowUrl: shadow, // Ganti dengan path ke bayangan Anda
      shadowSize: [41, 41] // Ukuran bayangan
    });

    // Tambahkan marker yang bisa dipindahkan (draggable)
    var marker = L.marker([lat, lng], {
      icon: customIcon,
      draggable: true
    }).addTo(map);

    // Dapatkan nilai radius awal dari input
    var radiusValue = document.getElementById('radius').value;

    // Tambahkan lingkaran dengan radius awal
    var circle = L.circle(marker.getLatLng(), {
      radius: radiusValue, // Radius dalam meter
      color: 'blue',
      fillOpacity: 0.2
    }).addTo(map);

    // Fungsi untuk memperbarui radius lingkaran
    function updateCircleRadius() {
      var newRadius = document.getElementById('radius').value;
      circle.setRadius(newRadius); // Perbarui radius lingkaran
    }

    // Event listener untuk input manual radius
    document.getElementById('radius').addEventListener('input', function () {
      document.getElementById('radius-input').value = this
        .value; // Sinkronkan dengan slider range
      updateCircleRadius();
    });

    // Event listener untuk slider range radius
    document.getElementById('radius-input').addEventListener('input', function () {
      document.getElementById('radius').value = this.value; // Sinkronkan dengan input manual
      updateCircleRadius();
    });

    // Variabel untuk menyimpan lokasi sebelumnya
    let previousPosition = {
      lat: lat,
      lng: lng
    };

    // Fungsi untuk memeriksa jarak dan mengupdate lokasi
    function checkLocation() {
      navigator.geolocation.getCurrentPosition(function (position) {
        var currentLat = position.coords.latitude;
        var currentLng = position.coords.longitude;

        var currentPosition = {
          lat: currentLat,
          lng: currentLng
        };
        var distance = getDistance(previousPosition, currentPosition);

        // Jika jarak lebih dari 100 meter, beri tahu pengguna
        if (distance > 50) {
          alert("Fake GPS terdeteksi! Perubahan lokasi melebihi 100 meter.");
        }

        // Update posisi marker dan input longitude dan latitude
        marker.setLatLng(currentPosition);
        document.getElementById('longitude').value = currentLng;
        document.getElementById('latitude').value = currentLat;

        // Update posisi sebelumnya
        previousPosition = currentPosition;

        // Memindahkan lingkaran ke lokasi baru
        circle.setLatLng(currentPosition);
      });
    }

    // Fungsi untuk menghitung jarak antara dua koordinat
    function getDistance(pos1, pos2) {
      var R = 6371000; // radius bumi dalam meter
      var dLat = (pos2.lat - pos1.lat) * Math.PI / 180;
      var dLng = (pos2.lng - pos1.lng) * Math.PI / 180;

      var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(pos1.lat * Math.PI / 180) * Math.cos(pos2.lat * Math.PI / 180) *
        Math.sin(dLng / 2) * Math.sin(dLng / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var distance = R * c; // dalam meter

      return distance;
    }

    // Update lokasi setiap 10 detik
    setInterval(checkLocation, 5000);

    // Event listener untuk mendeteksi perubahan posisi marker
    marker.on('dragend', function (event) {
      var position = marker.getLatLng();
      marker.setLatLng(position, {
        draggable: true
      });

      // Update input longitude dan latitude (jika diperlukan)
      document.getElementById('longitude').value = position.lng;
      document.getElementById('latitude').value = position.lat;
    });
  }

  // Gunakan Geolocation API untuk mendapatkan lokasi pengguna
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;

        // Panggil fungsi untuk inisialisasi peta dengan lokasi pengguna
        initializeMap(lat, lng);
      },
      function (error) {
        console.error("Error mendapatkan lokasi:", error);
        // Jika gagal, gunakan lokasi default
        initializeMap(3.594361307230664, 98.67298838708204);
      }
    );
  } else {
    // Jika browser tidak mendukung Geolocation, gunakan lokasi default
    initializeMap(3.594361307230664, 98.67298838708204);
  }
});