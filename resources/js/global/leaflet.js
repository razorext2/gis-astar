import "leaflet/dist/leaflet.css";
import "leaflet-routing-machine/dist/leaflet-routing-machine.css";
import L from "leaflet";
import "leaflet-routing-machine";

export function initDistribution() {
  // Fungsi untuk inisialisasi peta dengan koordinat yang diberikan
  function initializeMap() {
    // Inisialisasi peta tanpa titik awal
    var map = L.map('map').setView([-2.544021, 118.042905], 4); // Default location Indonesia

    // Menambahkan Tile Layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Custom icon untuk marker
    var customIcon = L.icon({
      iconUrl: `${APP_URL}/assets/img/marker.png`, // Ganti dengan path ke ikon Anda
      iconSize: [25, 41], // Ukuran ikon
      iconAnchor: [12, 41], // Titik untuk mengaitkan ikon ke koordinat
      shadowUrl: `${APP_URL}/assets/img/marker-shadow.png`, // Ganti dengan path ke bayangan Anda
      shadowSize: [41, 41] // Ukuran bayangan
    });

    // Ambil data waypoints dari API
    fetch(`${APP_URL}/api/map-distribution`)
      .then(response => response.json())
      .then(data => {
        const waypoints = data.map(item => ({
          coords: L.latLng(
            item.latitude ? item.latitude : 3.591516090416829,
            item.longitude ? item.longitude : 98.66902828216554
          ),
          kodePegawai: item.kode_pegawai ?? 'Kode siapa ini?',
          fullName: item.pegawai_relasi.full_name ?? 'Siapa ya',
        }));

        // Menambahkan marker untuk setiap titik di waypoints
        waypoints.forEach(function (point) {
          L.marker(point.coords, {
            icon: customIcon
          })
            .addTo(map)
            .bindPopup(
              `<b>Kode Pegawai: ${point.kodePegawai}</b><br>${point.fullName}`);
        });

        // Menentukan bounds (batas) untuk menampilkan semua marker
        if (waypoints.length > 1) {
          var bounds = L.latLngBounds(waypoints.map(point => point.coords));
          map.fitBounds(bounds, {
            padding: [50, 50]
          }); // Tambahkan padding agar tidak terlalu ngefit
        }
      })
      .catch(error => {
        console.error('Error fetching waypoints:', error);
      });
  }

  // Inisialisasi peta dengan koordinat default
  initializeMap();
}