
// Get the elements
var rangeInput = document.getElementById('radius-input');
var currencyInput = document.getElementById('radius');

// Function to update the currency input
function updateCurrencyInput() {
  currencyInput.value = rangeInput.value;
}

// Add event listener to the range input
rangeInput.addEventListener('input', updateCurrencyInput);

document.addEventListener('DOMContentLoaded', function () {
  // Inisialisasi peta pada posisi awal
  var map = L.map('map').setView([lat, lng],
    17); // Jakarta

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
  }).addTo(map)

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

  // Event listener untuk mendeteksi perubahan posisi marker
  marker.on('dragend', function (event) {
    var position = marker.getLatLng();
    circle.setLatLng(position); // Pindahkan lingkaran mengikuti marker

    // Update input longitude dan latitude
    document.getElementById('longitude').value = position.lng;
    document.getElementById('latitude').value = position.lat;

    // Perbarui popup dengan posisi baru
    marker.setLatLng(position, {
      draggable: true
    });
  });
});