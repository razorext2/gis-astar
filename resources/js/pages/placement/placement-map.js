/**
 * placement-map.js
 * Shared Leaflet map handler untuk halaman add & edit penempatan.
 *
 * Bridge ke Livewire via window.CustomEvent (tidak ada coupling ke framework):
 *   - Marker drag/click → dispatch 'map-pin-updated' { lat, lng }
 *   - Alpine mendengar 'placement-radius-changed' { radius } → update circle
 */
document.addEventListener("DOMContentLoaded", function () {
    const mapEl = document.getElementById("placement-map");
    if (!mapEl) return;

    // Baca config dari data-* attributes — tidak ada global variables
    const iconUrl = mapEl.dataset.icon;
    const shadowUrl = mapEl.dataset.shadow;
    const initLat = parseFloat(mapEl.dataset.lat) || null;
    const initLng = parseFloat(mapEl.dataset.lng) || null;
    const initRadius = parseInt(mapEl.dataset.radius) || 100;

    // Koordinat default fallback (Medan)
    const DEFAULT_LAT = 3.594361307230664;
    const DEFAULT_LNG = 98.67298838708204;

    function initializeMap(lat, lng) {
        const map = L.map("placement-map").setView([lat, lng], 17);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        const customIcon = L.icon({
            iconUrl,
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            shadowUrl,
            shadowSize: [41, 41],
        });

        const marker = L.marker([lat, lng], {
            icon: customIcon,
            draggable: true,
        }).addTo(map);
        const UNLIMITED_RADIUS = 999999999;
        const isUnlimited = initRadius >= UNLIMITED_RADIUS;
        const circle = L.circle(marker.getLatLng(), {
            radius: isUnlimited ? 0 : initRadius,
            color: "#3b82f6",
            opacity: isUnlimited ? 0 : 1,
            fillOpacity: isUnlimited ? 0 : 0.15,
        }).addTo(map);

        /** Dispatch koordinat baru ke Livewire via Alpine */
        function notifyCoordinate(position) {
            window.dispatchEvent(
                new CustomEvent("map-pin-updated", {
                    detail: { lat: position.lat, lng: position.lng },
                }),
            );
        }

        /** Update visibilitas dan ukuran lingkaran radius */
        function applyCircleStyle(r) {
            if (r >= UNLIMITED_RADIUS) {
                circle.setRadius(0);
                circle.setStyle({ opacity: 0, fillOpacity: 0 });
            } else {
                circle.setRadius(r);
                circle.setStyle({ opacity: 1, fillOpacity: 0.15 });
            }
        }

        // Marker drag
        marker.on("dragend", function () {
            const pos = marker.getLatLng();
            circle.setLatLng(pos);
            notifyCoordinate(pos);
        });

        // Klik langsung di peta → pindahkan marker
        map.on("click", function (e) {
            marker.setLatLng(e.latlng);
            circle.setLatLng(e.latlng);
            notifyCoordinate(e.latlng);
        });

        // Alpine mengirim radius baru → update lingkaran
        window.addEventListener("placement-radius-changed", function (e) {
            const r = parseInt(e.detail.radius);
            if (!isNaN(r)) {
                applyCircleStyle(r);
            }
        });

        // Notifikasi koordinat awal ke Livewire (terutama saat create + geolocation)
        notifyCoordinate({ lat, lng });
    }

    // Jika ada koordinat existing (edit mode), pakai langsung
    if (initLat && initLng) {
        initializeMap(initLat, initLng);
        return;
    }

    // Fallback ke geolocation (create mode)
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (pos) => initializeMap(pos.coords.latitude, pos.coords.longitude),
            () => initializeMap(DEFAULT_LAT, DEFAULT_LNG),
        );
    } else {
        initializeMap(DEFAULT_LAT, DEFAULT_LNG);
    }
});
