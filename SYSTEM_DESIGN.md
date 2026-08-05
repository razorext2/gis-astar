# System Design & Architecture Guide
## GIS-Astar — Sistem Perujukan Otomatis berbasis A*

> Dokumen ini adalah panduan teknis definitif untuk memahami, mengembangkan, dan memelihara sistem perujukan otomatis GIS-Astar.
> Baca seluruh dokumen sebelum melakukan perubahan arsitektural.

---

## Daftar Isi

1. [Gambaran Sistem](#1-gambaran-sistem)
2. [Keputusan Teknis Final](#2-keputusan-teknis-final)
3. [Tech Stack](#3-tech-stack)
4. [Arsitektur Lapisan (Layer Architecture)](#4-arsitektur-lapisan)
5. [Entitas ERD → Model Laravel](#5-entitas-erd--model-laravel)
6. [Alur Kerja Utama: Proses Perujukan](#6-alur-kerja-utama)
7. [Desain Service Classes](#7-desain-service-classes)
8. [Algoritma A*](#8-algoritma-a)
9. [Struktur Direktori Definitif](#9-struktur-direktori-definitif)
10. [Desain Model & Relasi Eloquent](#10-desain-model--relasi-eloquent)
11. [Alur Request-Response](#11-alur-request-response)
12. [Pola Arsitektur Handler](#12-pola-arsitektur-handler)
13. [Routes & Navigasi](#13-routes--navigasi)
14. [RBAC — Roles & Permissions](#14-rbac--roles--permissions)
15. [Frontend Architecture (Peta Interaktif)](#15-frontend-architecture)
16. [Diagram Sequence Perujukan](#16-diagram-sequence)
17. [Caching Strategy](#17-caching-strategy)
18. [Error Handling System](#18-error-handling-system)
19. [Security Architecture](#19-security-architecture)
20. [Activity Logging](#20-activity-logging)
21. [Panduan: Do & Don't](#21-panduan-do--dont)
22. [Behavior Rules per Layer](#22-behavior-rules-per-layer)
23. [Panduan Tambah Domain Baru](#23-panduan-tambah-domain-baru)

---

## 1. Gambaran Sistem

GIS-Astar adalah **web application** berbasis **Laravel 13 + Livewire 4** untuk sistem perujukan pasien otomatis. Sistem menggunakan algoritma **A\*** (A-Star) untuk menemukan rumah sakit rujukan terbaik berdasarkan posisi pasien, diintegrasikan dengan **OpenStreetMap** sebagai penyedia peta dan data geografis.

```
+-----------------------------------------------------------+
|                     BROWSER (SPA)                         |
|  Leaflet.js + OSM Tiles + navigator.geolocation GPS       |
|         Livewire wire:navigate — no full reload           |
+------------------------------+----------------------------+
                               | HTTP
+------------------------------v----------------------------+
|               Laravel Application Server                  |
|               (PHP 8.4 + Octane/FPM)                      |
|                                                           |
|  Middleware Stack → Router → Livewire Handler             |
|         ↓                                                 |
|  ReferralService (Orkestrator — SYNCHRONOUS)              |
|         ↓                          ↓                      |
|  AStarService              GeocodingService               |
|  (Haversine heuristic)     (Nominatim OSM API)            |
|         ↓                                                 |
|  HospitalScoringService                                   |
|  (Filter JSON layanan, radius km)                         |
+------------------------------+----------------------------+
           |                   |              |
    MySQL Database        Redis Cache    OpenStreetMap
    (Eloquent ORM)    (Kandidat RS,     (Nominatim API
                       Geocoding)        dev mode)
```

---

## 2. Keputusan Teknis Final

| # | Aspek | Keputusan |
|---|---|---|
| 1 | **Road Network** | OpenStreetMap (Nominatim API) — mode development, heuristic & cost = Haversine |
| 2 | **Koordinat Pasien** | Dual-mode: input manual form **+** auto-detect GPS (`navigator.geolocation`) |
| 3 | **A\* Execution** | **Synchronous** — langsung dalam Livewire request cycle, `wire:loading` sebagai feedback |
| 4 | **Format `layanan_operasi`** | **JSON array** — contoh: `["ICU","IGD","Bedah"]`, cast Eloquent + filter `JSON_CONTAINS` |

---

## 3. Tech Stack

| Layer | Package | Versi | Catatan |
|---|---|---|---|
| **Backend** | Laravel Framework | ^13.0 | Foundation |
| **PHP** | PHP | 8.4 | Property promotion, enums, fibers |
| **Auth/Session** | Laravel Breeze | v2 | Auth scaffolding |
| **Livewire** | Livewire | ^4.0 | Full-page SPA, wire:navigate |
| **RBAC** | Spatie Permission | ^8.0 | Role & Permission management |
| **Tables** | LiveWire PowerGrid | ^6.1 | Data tables dengan filter & sort |
| **Performance** | Laravel Octane | ^2.6 | Long-running PHP server |
| **CSS** | Tailwind CSS | ^3.4 | Utility-first styling |
| **Alpine.js** | Alpine.js | ^3.14 | Client-side interactivity |
| **Peta** | Leaflet.js | ^1.9 | Peta interaktif OSM tiles |
| **Geocoding** | Nominatim OSM API | public | Reverse geocoding + search |
| **Alerts** | SweetAlert2 | ^11 | User feedback (swal event) |
| **Date Picker** | Flatpickr | ^4.6 | Input date component |
| **Select** | Tom Select | ^2.4 | Searchable select (CDN) |
| **Testing** | Pest | ^4.0 | Behavior-driven testing |
| **Formatter** | Laravel Pint | ^1.0 | Code style enforcer |
| **Queue** | Laravel Horizon | ^5.47 | Background jobs dashboard |
| **Cache** | Redis | latest | Kandidat RS, geocoding cache |

---

## 4. Arsitektur Lapisan

```
+------------------------------------------------------------------+
|  PRESENTATION LAYER                                              |
|  ┌───────────────────────────────────────────────────────────┐  |
|  │  Blade Layouts (layouts/app.blade.php)                    │  |
|  │  ┌── Livewire Handler/Rujukan/Create.php  (Form + A*)     │  |
|  │  ├── Livewire Handler/Rujukan/Index.php   (Tabel list)    │  |
|  │  ├── Livewire Handler/Rujukan/Show.php    (Detail + peta) │  |
|  │  ├── Livewire Handler/Rujukan/UpdateStatus.php            │  |
|  │  ├── Livewire Handler/Pasien/...          (CRUD pasien)   │  |
|  │  ├── Livewire Handler/RumahSakit/...      (CRUD RS)       │  |
|  │  ├── Livewire Utils/MapPicker.php         (Pilih lokasi)  │  |
|  │  └── Livewire Utils/RutePreview.php       (Pratinjau rute)│  |
|  └───────────────────────────────────────────────────────────┘  |
+------------------------------------------------------------------+
         ↓ wire:click, wire:model, wire:navigate
+------------------------------------------------------------------+
|  APPLICATION LAYER                                               |
|  ┌───────────────────────────────────────────────────────────┐  |
|  │  Services/ReferralService.php       ← Orkestrator utama   │  |
|  │  Services/AStarService.php          ← Algoritma A*        │  |
|  │  Services/HospitalScoringService.php ← Filter & ranking   │  |
|  │  Services/GeocodingService.php      ← Nominatim wrapper   │  |
|  │  Concerns/HandlesErrors.php         ← CRITICAL TRAIT      │  |
|  └───────────────────────────────────────────────────────────┘  |
+------------------------------------------------------------------+
         ↓ Eloquent
+------------------------------------------------------------------+
|  DOMAIN LAYER                                                    |
|  ┌───────────────────────────────────────────────────────────┐  |
|  │  Models: Pasien, RumahSakit, Rujukan, DetailRujukan,      │  |
|  │          Rute, TitikRute, RiwayatRujukan                  │  |
|  │  Enums: StatusRujukan, JenisKelamin, TipeTitikRute,       │  |
|  │         MetodeRujukan                                      │  |
|  │  DTOs: AStarResult, ReferralProcessResult, GeoPoint       │  |
|  │  Events: RujukanDibuatEvent, StatusRujukanBerubahEvent    │  |
|  └───────────────────────────────────────────────────────────┘  |
+------------------------------------------------------------------+
         ↓
+------------------------------------------------------------------+
|  INFRASTRUCTURE LAYER                                            |
|  ┌─────────────┐ ┌────────────────┐ ┌────────────────────────┐  |
|  │ MySQL        │ │ Redis Cache    │ │ External APIs          │  |
|  │ (Eloquent)   │ │ (Kandidat RS,  │ │ - Nominatim (Geocoding)│  |
|  │              │ │  Geocoding)    │ │ - OSM Tiles (Leaflet)  │  |
|  └─────────────┘ └────────────────┘ └────────────────────────┘  |
+------------------------------------------------------------------+
```

---

## 5. Entitas ERD → Model Laravel

| Tabel ERD | Model Laravel | Relasi Utama |
|---|---|---|
| `users` | `User` (existing) | hasMany Rujukan, hasMany Pasien (input oleh) |
| `pasien` | `Pasien` | belongsTo User, hasMany Rujukan |
| `rumah_sakit_rujukan` | `RumahSakit` | hasMany Rujukan, hasMany RiwayatRujukan |
| `rujukan` | `Rujukan` | belongsTo Pasien/RumahSakit/User, hasOne DetailRujukan, hasMany RiwayatRujukan |
| `detail_rujukan` | `DetailRujukan` | belongsTo Rujukan, belongsTo Rute |
| `rute` | `Rute` | hasMany TitikRute, hasOne DetailRujukan |
| `titik_rute` | `TitikRute` | belongsTo Rute |
| `riwayat_rujukan` | `RiwayatRujukan` | belongsTo Rujukan |

---

## 6. Alur Kerja Utama

### Proses Perujukan Otomatis (Happy Path)

```
Dokter membuka form rujukan
        │
        ▼
[1] Pilih Pasien
    → Load data pasien (nama, alamat, lat/lng) dari DB
    → Tampilkan lokasi pasien di peta Leaflet
        │
        ▼
[2] Pilih Layanan yang Dibutuhkan (dropdown dari layanan_operasi JSON)
        │
        ▼
[3] Klik "Cari Rujukan Terbaik"
    → wire:loading spinner aktif
        │
        ▼
[4] HospitalScoringService::getCandidates(lat, lng, layanan)
    → WHERE JSON_CONTAINS(layanan_operasi, '"ICU"')
    → Filter Haversine ≤ N km
    → Limit 10 kandidat terdekat
        │
        ▼
[5] AStarService::findBestHospital(fromLat, fromLng, kandidatRS[])
    ┌──────────────────────────────────────────────────────┐
    │  Untuk setiap kandidat RS:                           │
    │    g(n) = Haversine(pasien → RS)  [cost]             │
    │    h(n) = 0 karena RS adalah tujuan akhir            │
    │    f(n) = g(n)  ← pilih RS dengan f terkecil         │
    │                                                      │
    │  Haversine Formula:                                  │
    │    a = sin²(Δlat/2) + cos(lat1)·cos(lat2)·sin²(Δlng/2) │
    │    c = 2·atan2(√a, √(1−a))                          │
    │    d = R · c   (R = 6371 km)                        │
    │                                                      │
    │  Hasil: allRanked[] diurutkan f(n) terkecil          │
    └──────────────────────────────────────────────────────┘
        │
        ▼
[6] ReferralService::persistResult() — DB::transaction()
    → INSERT rute (nama, jarak_total, waktu_total, algoritma='astar')
    → INSERT titik_rute (awal=pasien, tujuan=RS terpilih)
    → INSERT rujukan (id_pasien, id_rumah_sakit, id_user, status='pending')
    → INSERT detail_rujukan (id_rujukan, id_rute, jarak, waktu_tempuh, estimasi_biaya)
        │
        ▼
[7] Response ke browser
    → Render peta Leaflet: marker pasien + marker RS + polyline lurus
    → Tampilkan tabel ranking 3 RS teratas (f terkecil di atas)
    → Dokter klik "Konfirmasi" → status = 'disetujui'
    → Event: RujukanDibuatEvent (Notifikasi DB)
    → INSERT riwayat_rujukan (status_lama='pending', status_baru='disetujui')
```

---

## 7. Desain Service Classes

### 7.1 AStarService

Menggunakan **Haversine** sebagai fungsi cost `g(n)` sekaligus heuristic `h(n)` (mode development OSM — tanpa road routing server). Pada mode production, `g(n)` dapat diganti dengan jarak jalan dari OSRM/GraphHopper.

```php
// app/Services/AStarService.php

class AStarService
{
    /**
     * Temukan RS terbaik dan ranking semua kandidat via A*.
     *
     * Cost g(n)      = Haversine distance (km) — OSM dev mode
     * Heuristic h(n) = 0 (RS adalah goal node langsung)
     * f(n)           = g(n)
     */
    public function findBestHospital(
        float $fromLat,
        float $fromLng,
        Collection $hospitals  // Collection<RumahSakit>
    ): AStarResult;

    /**
     * Haversine formula — admissible heuristic.
     * Selalu ≤ jarak jalan nyata.
     */
    private function haversine(
        float $lat1, float $lng1,
        float $lat2, float $lng2
    ): float; // km

    /**
     * Estimasi waktu tempuh dari jarak.
     * Asumsi kecepatan rata-rata 40 km/jam dalam kota.
     */
    private function estimateTime(float $distanceKm): int; // menit

    /**
     * Estimasi biaya rujukan berdasarkan jarak.
     * Asumsi tarif ambulan Rp 5.000/km (configurable di Setting).
     */
    private function estimateCost(float $distanceKm): float; // rupiah
}
```

### 7.2 ReferralService (Orkestrator)

```php
// app/Services/ReferralService.php

class ReferralService
{
    public function __construct(
        private readonly AStarService $astar,
        private readonly HospitalScoringService $scoring,
    ) {}

    /**
     * Entry point utama — dipanggil dari Livewire Handler.
     * Berjalan SYNCHRONOUS dalam request cycle.
     */
    public function processReferral(
        Pasien $pasien,
        string $layananDibutuhkan,
        User $requestedBy
    ): ReferralProcessResult;

    /**
     * Simpan semua hasil ke DB dalam satu transaksi.
     * Urutan: rute → titik_rute → rujukan → detail_rujukan
     */
    private function persistResult(
        AStarResult $result,
        Pasien $pasien,
        User $user
    ): Rujukan;
}
```

### 7.3 HospitalScoringService

`layanan_operasi` disimpan sebagai JSON array. Filter menggunakan `JSON_CONTAINS` MySQL dan Haversine PHP untuk sorting radius.

```php
// app/Services/HospitalScoringService.php

class HospitalScoringService
{
    /**
     * Ambil kandidat RS berdasarkan layanan (JSON) + radius km.
     *
     * layanan_operasi contoh: ["ICU","IGD","Bedah","NICU"]
     * Filter: WHERE JSON_CONTAINS(layanan_operasi, '"ICU"')
     */
    public function getCandidates(
        float $lat,
        float $lng,
        string $layanan,    // contoh: "ICU"
        int $radiusKm = 50,
        int $limit = 10
    ): Collection; // Collection<RumahSakit> diurutkan terdekat

    /**
     * Query builder dengan filter JSON_CONTAINS.
     * Menggunakan MySQL native JSON function untuk performa.
     */
    private function queryByLayanan(string $layanan): Builder;

    /**
     * Haversine untuk filter radius & sorting kandidat.
     */
    private function haversineDistance(
        float $lat1, float $lng1,
        float $lat2, float $lng2
    ): float;
}
```

### 7.4 GeocodingService

```php
// app/Services/GeocodingService.php

class GeocodingService
{
    private const NOMINATIM_BASE = 'https://nominatim.openstreetmap.org';

    /**
     * Reverse geocoding: lat/lng → alamat teks.
     * Cache 24 jam di Redis.
     */
    public function reverseGeocode(float $lat, float $lng): string;

    /**
     * Forward geocoding: teks alamat → lat/lng.
     * Cache 24 jam di Redis.
     */
    public function geocode(string $address): ?GeoPoint;
}
```

---

## 8. Algoritma A*

### Pseudocode

```
INPUT : pasienPoint {lat, lng}
        hospitalList [{id, lat, lng, layanan_operasi}]
OUTPUT: AStarResult {bestHospital, allRanked, totalDistance, estimatedTime}

PROCEDURE FindBestHospital(pasienPoint, hospitalList):

  1. scores ← []

  2. FOR each hospital H in hospitalList:
       g ← haversine(pasienPoint, H)   // cost = jarak km
       h ← 0                           // H adalah goal node
       f ← g + h                       // f(n) = g(n)
       scores.append({hospital: H, f: f, distance: g})

  3. scores.sortBy(f, ascending=true)

  4. best ← scores[0]
  5. waypoints ← [
       GeoPoint(pasienPoint.lat, pasienPoint.lng, tipe='awal'),
       GeoPoint(best.lat, best.lng, tipe='tujuan')
     ]

  6. RETURN AStarResult {
       bestHospital  : best.hospital,
       allRanked     : scores,         // Top 3 ditampilkan di UI
       totalDistance : best.distance,
       estimatedTime : estimateTime(best.distance),
       estimatedCost : estimateCost(best.distance),
       waypoints     : waypoints,
       algorithm     : 'astar'
     }

FUNCTION haversine(p1, p2):
  R ← 6371  // radius bumi km
  dLat ← toRad(p2.lat - p1.lat)
  dLng ← toRad(p2.lng - p1.lng)
  a ← sin(dLat/2)² + cos(toRad(p1.lat)) · cos(toRad(p2.lat)) · sin(dLng/2)²
  c ← 2 · atan2(√a, √(1-a))
  RETURN R · c

FUNCTION estimateTime(distanceKm):
  RETURN ceil((distanceKm / 40) * 60)  // 40 km/jam → menit

FUNCTION estimateCost(distanceKm):
  RETURN distanceKm * 5000  // Rp 5.000/km (tarif ambulan)
```

### Kenapa Haversine Sebagai Heuristic

| Properti | Nilai |
|---|---|
| **Admissible** | Ya — Haversine ≤ jarak jalan nyata selalu |
| **Consistent** | Ya — memenuhi triangle inequality |
| **Kompleksitas** | O(n) untuk n kandidat RS |
| **Mode** | Development: Haversine saja. Production: g(n) = OSRM road distance |

---

## 9. Struktur Direktori Definitif

```
gis-astar/
├── app/
│   ├── Console/               # Artisan commands
│   ├── DTOs/                  # Value Objects / Data Transfer Objects
│   │   ├── AStarResult.php    # Hasil kalkulasi A*
│   │   ├── GeoPoint.php       # {lat, lng, label, tipe}
│   │   └── ReferralProcessResult.php
│   ├── Enums/
│   │   ├── StatusRujukan.php  # pending, disetujui, ditolak, selesai
│   │   ├── TipeTitikRute.php  # awal, perantara, tujuan
│   │   ├── MetodeRujukan.php  # manual, otomatis
│   │   └── JenisKelamin.php   # laki_laki, perempuan
│   ├── Events/
│   │   ├── RujukanDibuatEvent.php
│   │   └── StatusRujukanBerubahEvent.php
│   ├── Exceptions/
│   │   └── BusinessException.php  # Exception bisnis (user-facing message)
│   ├── Helpers/
│   │   └── ErrorLogger.php        # Centralized error logger dengan UUID
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   │       ├── LogUserActions.php
│   │       ├── TrackUserActivity.php
│   │       └── RemoveHeadersMiddleware.php
│   ├── Livewire/
│   │   ├── Concerns/
│   │   │   └── HandlesErrors.php   # CRITICAL TRAIT — wajib di semua Handler
│   │   ├── Handler/
│   │   │   ├── Rujukan/
│   │   │   │   ├── Index.php       # Tabel daftar rujukan (PowerGrid)
│   │   │   │   ├── Create.php      # Form buat rujukan + trigger A*
│   │   │   │   ├── Show.php        # Detail + peta rute Leaflet
│   │   │   │   └── UpdateStatus.php # Setuju/Tolak rujukan
│   │   │   ├── Pasien/
│   │   │   │   ├── Index.php
│   │   │   │   ├── Create.php
│   │   │   │   └── Edit.php
│   │   │   └── RumahSakit/
│   │   │       ├── Index.php
│   │   │       ├── Create.php
│   │   │       └── Edit.php
│   │   ├── PowergridTables/
│   │   │   ├── RujukanTable.php
│   │   │   ├── PasienTable.php
│   │   │   └── RumahSakitTable.php
│   │   └── Utils/
│   │       ├── MapPicker.php       # Pilih koordinat (manual + GPS)
│   │       ├── RutePreview.php     # Pratinjau rute + waypoints
│   │       ├── Breadcrumb.php
│   │       └── NotificationDropdown.php
│   ├── Models/
│   │   ├── User.php               # existing
│   │   ├── Pasien.php
│   │   ├── RumahSakit.php
│   │   ├── Rujukan.php
│   │   ├── DetailRujukan.php
│   │   ├── Rute.php
│   │   ├── TitikRute.php
│   │   └── RiwayatRujukan.php
│   ├── Observers/
│   │   └── RujukanObserver.php    # Auto-log riwayat saat status berubah
│   └── Services/
│       ├── AStarService.php       # ← Inti algoritma A*
│       ├── ReferralService.php    # ← Orkestrator
│       ├── HospitalScoringService.php
│       └── GeocodingService.php   # ← Nominatim wrapper
├── config/
│   └── navigation.php             # Config-driven sidebar navigation
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_pasien_table.php
│   │   ├── xxxx_create_rumah_sakit_rujukan_table.php
│   │   ├── xxxx_create_rujukan_table.php
│   │   ├── xxxx_create_detail_rujukan_table.php
│   │   ├── xxxx_create_rute_table.php
│   │   ├── xxxx_create_titik_rute_table.php
│   │   └── xxxx_create_riwayat_rujukan_table.php
│   ├── factories/
│   └── seeders/
│       ├── RumahSakitSeeder.php   # Data dummy RS + koordinat
│       └── PasienSeeder.php
├── resources/
│   ├── css/app.css
│   ├── js/
│   │   ├── app.js
│   │   ├── main.js
│   │   └── utils/
│   │       ├── alert.js
│   │       ├── eventListener.js
│   │       └── map.js             # ← Helper Leaflet + GPS detect
└── routes/
    ├── web.php
    └── auth.php
```

> **ATURAN KRITIS**: Jangan buat folder baru di luar struktur ini. Jika domain baru dibutuhkan, buat subdirektori di `Handler/NamaDomain/` mengikuti pattern yang ada.

---

## 10. Desain Model & Relasi Eloquent

```php
// app/Models/Pasien.php
class Pasien extends Model
{
    protected $casts = [
        'jenis_kelamin' => JenisKelamin::class,
        'tanggal_lahir' => 'date',
        'latitude'      => 'float',
        'longitude'     => 'float',
    ];

    public function user(): BelongsTo;      // dokter yang menginput
    public function rujukan(): HasMany;
}

// app/Models/RumahSakit.php
class RumahSakit extends Model
{
    protected $table = 'rumah_sakit_rujukan';

    protected $casts = [
        'layanan_operasi' => 'array',   // ← JSON array: ["ICU","IGD"]
        'latitude'        => 'float',
        'longitude'       => 'float',
    ];

    public function rujukan(): HasMany;
    public function riwayat(): HasManyThrough; // via Rujukan

    // Accessor: daftar layanan sebagai array
    public function getLayananListAttribute(): array
    {
        return $this->layanan_operasi ?? [];
    }

    // Scope: RS yang punya layanan tertentu (JSON_CONTAINS)
    public function scopeHasLayanan(Builder $query, string $layanan): Builder
    {
        return $query->whereRaw(
            "JSON_CONTAINS(layanan_operasi, ?)",
            ['"' . $layanan . '"']
        );
    }
}

// app/Models/Rujukan.php
class Rujukan extends Model
{
    protected $casts = [
        'status'          => StatusRujukan::class,
        'tanggal_rujukan' => 'datetime',
    ];

    public function pasien(): BelongsTo;
    public function rumahSakit(): BelongsTo;
    public function user(): BelongsTo;       // dokter yang membuat
    public function detailRujukan(): HasOne;
    public function riwayat(): HasMany;      // RiwayatRujukan
}

// app/Models/Rute.php
class Rute extends Model
{
    public function titikRute(): HasMany;    // ordered by urutan
    public function detailRujukan(): HasOne;

    public function getTitikTerurut(): Collection
    {
        return $this->titikRute()->orderBy('urutan')->get();
    }
}

// app/Models/TitikRute.php
class TitikRute extends Model
{
    protected $casts = [
        'tipe'      => TipeTitikRute::class, // awal, perantara, tujuan
        'latitude'  => 'float',
        'longitude' => 'float',
    ];

    public function rute(): BelongsTo;
}

// app/Models/RiwayatRujukan.php
// Di-trigger otomatis oleh RujukanObserver saat status berubah
class RiwayatRujukan extends Model
{
    public function rujukan(): BelongsTo;
    public function diubahOleh(): BelongsTo; // belongsTo User
}
```

---

## 11. Alur Request-Response

### GET Request (Akses Halaman)

```
User → Browser
  ↓ HTTP GET /rujukan/create
Router (web.php)
  ↓ middleware(['auth', 'permission:rujukan-create'])
Livewire Handler\Rujukan\Create::class
  ↓ mount() → load daftar pasien, load daftar layanan
  ↓ render() → return view('livewire.handler.rujukan.create')
Blade View → layouts.app.blade.php
  ↓ embed <livewire:utils.map-picker />
Leaflet.js → Load OSM tiles → Tampilkan peta
```

### POST Action: Cari Rujukan (A* Trigger)

```
Dokter klik [Cari Rujukan Terbaik]
  ↓ wire:click="searchReferral"
Livewire AJAX → /livewire/update
  ↓
Handler\Rujukan\Create::searchReferral()
  ↓ $this->validate()
  ↓ $this->runSafely(function () {
       $pasien = Pasien::findOrFail($this->pasienId);
       $result = $this->referralService->processReferral(
           $pasien, $this->layanan, auth()->user()
       );
       $this->astarResult = $result;
       $this->rujukanId = $result->rujukan->id;
     })
  ↓ wire:loading → spinner hilang
Livewire DOM diff → render peta + tabel ranking RS
```

### POST Action: Konfirmasi Rujukan (Status Update)

```
Dokter klik [Konfirmasi Rujukan]
  ↓ wire:click="confirm"
Handler\Rujukan\Create::confirm()
  ↓ runSafely → DB::transaction
       Rujukan::update(['status' => StatusRujukan::Disetujui])
       // RujukanObserver::updated() → INSERT riwayat_rujukan
       Event::dispatch(new RujukanDibuatEvent(...))
  ↓ dispatch('swal', success)
  ↓ redirect(route('rujukan.show', $rujukanId), navigate: true)
```

---

## 12. Pola Arsitektur Handler

Handler adalah full-page Livewire component yang menjadi pusat logika domain.

### Anatomi Handler Standard

```php
<?php
// app/Livewire/Handler/Rujukan/Create.php

namespace App\Livewire\Handler\Rujukan;

use App\Livewire\Concerns\HandlesErrors;
use App\Services\ReferralService;
use App\Enums\StatusRujukan;
use App\Models\Pasien;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors; // WAJIB — jangan pernah skip ini

    // Properties: typed, nullable, dengan default
    public ?int $pasienId = null;
    public ?string $layanan = null;
    public ?array $astarResult = null;
    public ?int $rujukanId = null;

    public function mount(): void
    {
        // Load supporting data
    }

    protected function rules(): array
    {
        return [
            'pasienId' => 'required|exists:pasien,id_pasien',
            'layanan'  => 'required|string',
        ];
    }

    public function searchReferral(): void
    {
        $this->validate();

        $this->runSafely(function () {
            $pasien = Pasien::findOrFail($this->pasienId);
            $result = app(ReferralService::class)->processReferral(
                $pasien, $this->layanan, auth()->user()
            );
            $this->astarResult = $result->toArray();
            $this->rujukanId   = $result->rujukan->id;
        }, 'Gagal memproses rujukan A*', [
            'pasien_id' => $this->pasienId,
            'layanan'   => $this->layanan,
        ]);
    }

    public function confirm(): void
    {
        $this->runSafely(function () {
            DB::transaction(function () {
                Rujukan::findOrFail($this->rujukanId)
                    ->update(['status' => StatusRujukan::Disetujui]);
            });

            $this->dispatch('swal', title: 'Berhasil', text: 'Rujukan dikonfirmasi.', icon: 'success');
            $this->redirect(route('rujukan.show', $this->rujukanId), navigate: true);
        }, 'Gagal konfirmasi rujukan');
    }

    public function render(): View
    {
        return view('livewire.handler.rujukan.create', [
            'pasienList'  => Pasien::query()->limit(200)->get(),
            'layananList' => RumahSakit::query()
                ->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(layanan_operasi, "$[*]")) as layanan')
                ->distinct()
                ->get(),
        ]);
    }
}
```

---

## 13. Routes & Navigasi

```php
// routes/web.php

use App\Livewire\Handler;

// Pasien
Route::prefix('pasien')->name('pasien.')->middleware(['auth'])->group(function () {
    Route::get('/',             Handler\Pasien\Index::class) ->name('index') ->middleware('permission:pasien-list');
    Route::get('/create',       Handler\Pasien\Create::class)->name('create')->middleware('permission:pasien-create');
    Route::get('/{pasien}/edit',Handler\Pasien\Edit::class)  ->name('edit')  ->middleware('permission:pasien-edit');
});

// Rumah Sakit
Route::prefix('rumah-sakit')->name('rumah-sakit.')->middleware(['auth'])->group(function () {
    Route::get('/',             Handler\RumahSakit\Index::class) ->name('index') ->middleware('permission:rs-list');
    Route::get('/create',       Handler\RumahSakit\Create::class)->name('create')->middleware('permission:rs-create');
    Route::get('/{rs}/edit',    Handler\RumahSakit\Edit::class)  ->name('edit')  ->middleware('permission:rs-edit');
});

// Rujukan
Route::prefix('rujukan')->name('rujukan.')->middleware(['auth'])->group(function () {
    Route::get('/',             Handler\Rujukan\Index::class)       ->name('index') ->middleware('permission:rujukan-list');
    Route::get('/create',       Handler\Rujukan\Create::class)      ->name('create')->middleware('permission:rujukan-create');
    Route::get('/{rujukan}',    Handler\Rujukan\Show::class)        ->name('show')  ->middleware('permission:rujukan-view');
    Route::get('/{rujukan}/status', Handler\Rujukan\UpdateStatus::class)->name('update-status')->middleware('permission:rujukan-update-status');
});
```

---

## 14. RBAC — Roles & Permissions

Menggunakan **Spatie Permission** dengan pola yang sama dengan project base.

### Permission Matrix

| Permission | admin | dokter | operator | rumah_sakit |
|---|:---:|:---:|:---:|:---:|
| `pasien-list` | ✅ | ✅ | ❌ | ❌ |
| `pasien-create` | ✅ | ✅ | ❌ | ❌ |
| `pasien-edit` | ✅ | ✅ | ❌ | ❌ |
| `rs-list` | ✅ | ✅ | ✅ | ✅ |
| `rs-create` | ✅ | ❌ | ❌ | ❌ |
| `rs-edit` | ✅ | ❌ | ❌ | ❌ |
| `rujukan-list` | ✅ | ✅ | ✅ | ✅ |
| `rujukan-create` | ✅ | ✅ | ❌ | ❌ |
| `rujukan-view` | ✅ | ✅ | ✅ | ✅ |
| `rujukan-update-status` | ✅ | ✅ | ✅ | ❌ |
| `settings-manage` | ✅ | ❌ | ❌ | ❌ |

### Level Authorization

| Level | Cara | Kapan |
|---|---|---|
| Route | `->middleware('permission:rujukan-list')` | Guard per URL — WAJIB |
| Component | `$this->authorize('update', $model)` | Jika butuh policy scope |
| Blade | `@can('rujukan-create')` | Sembunyikan UI element |
| Config | `'guard' => ['can', 'permission']` | Sidebar navigation |

---

## 15. Frontend Architecture

### Komponen MapPicker (Dual Mode: Manual + GPS)

```
┌─────────────────────────────────────────────────────────────┐
│  Form Rujukan (Livewire Handler/Rujukan/Create.php)          │
│  ┌───────────────────────────────────────────────────────┐  │
│  │  [Pilih Pasien ▾]      [Layanan Dibutuhkan ▾]        │  │
│  │                                                       │  │
│  │  Koordinat Pasien:                                    │  │
│  │  Lat: [ -6.200000  ]  Lng: [ 106.816666  ]           │  │
│  │  [📍 Deteksi Lokasi Saya]  ← navigator.geolocation   │  │
│  │                                                       │  │
│  │  ┌───────────────────────────────────────────────┐    │  │
│  │  │  🗺 PETA (Leaflet.js + OSM Tiles)             │    │  │
│  │  │                                               │    │  │
│  │  │  📍 Lokasi Pasien (marker draggable)          │    │  │
│  │  │  🏥 RS Kandidat A  (f = 3.2 km)               │    │  │
│  │  │  🏥 RS Kandidat B  (f = 5.7 km)               │    │  │
│  │  │  🏥 RS Kandidat C  (f = 8.1 km)               │    │  │
│  │  │  ════════════ Rute Terpilih (Polyline) ══════ │    │  │
│  │  └───────────────────────────────────────────────┘    │  │
│  │                                                       │  │
│  │  📊 Hasil Rekomendasi A* (wire:loading spinner):      │  │
│  │  ┌────────────────────────────────────────────────┐   │  │
│  │  │ #  │ Rumah Sakit      │ Jarak  │ Waktu │ Biaya │   │  │
│  │  │ 1✅│ RS Harapan Bunda │ 3.2 km │ 5 mnt │ 16rb  │   │  │
│  │  │ 2  │ RS Budi Mulia    │ 5.7 km │ 9 mnt │ 29rb  │   │  │
│  │  │ 3  │ RS Mitra Sehat   │ 8.1 km │12 mnt │ 41rb  │   │  │
│  │  └────────────────────────────────────────────────┘   │  │
│  │                                                       │  │
│  │  [Konfirmasi Rujukan]          [Batalkan]             │  │
│  └───────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

### GPS Auto-Detect Flow

```js
// resources/js/utils/map.js

window.detectGPS = function(wireComponent) {
    if (!navigator.geolocation) {
        Swal.fire('Error', 'Browser tidak mendukung GPS', 'error');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        (position) => {
            const { latitude, longitude } = position.coords;
            // Emit ke Livewire via $wire
            wireComponent.$wire.set('pasienLat', latitude);
            wireComponent.$wire.set('pasienLng', longitude);
            wireComponent.$wire.call('updateMapMarker', latitude, longitude);
        },
        (error) => {
            Swal.fire('Gagal', 'Tidak dapat mengakses GPS', 'warning');
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
};
```

### Leaflet Initialization (SPA-safe)

```js
// WAJIB: Re-initialize di livewire:navigated, bukan hanya DOMContentLoaded
document.addEventListener('livewire:navigated', () => {
    if (document.getElementById('rujukan-map')) {
        initRujukanMap();
    }
});

function initRujukanMap() {
    const map = L.map('rujukan-map').setView([-6.2, 106.8], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    // ... setup markers, polyline
}
```

### JS Library Rules

| Library | Cara Load | Catatan |
|---|---|---|
| Alpine.js | npm + import di app.js | Wajib |
| Leaflet.js | npm + import | Peta OSM |
| SweetAlert2 | npm + window.Swal | Global |
| Flatpickr | npm + import | Date picker |
| Tom Select | **CDN** saja | Khusus ini CDN by design |

---

## 16. Diagram Sequence

### Buat Rujukan Otomatis (Full Flow)

```
Dokter     Livewire          ReferralService   AStarService   Nominatim   MySQL
  │             │                   │                │            │           │
  │─pilih pasien▶                   │                │            │           │
  │─pilih layanan▶                  │                │            │           │
  │─klik Cari ──▶│                  │                │            │           │
  │             │─processReferral()─▶               │            │           │
  │             │                   │─getCandidates()             │           │
  │             │                   │────────────────────────────────────────▶│
  │             │                   │◀─── Collection<RumahSakit> ─────────────│
  │             │                   │                │            │           │
  │             │                   │─findBestHospital()─▶        │           │
  │             │                   │                │─haversine() (PHP)      │
  │             │                   │                │─sort by f(n)           │
  │             │                   │◀──── AStarResult ───────────│           │
  │             │                   │                │            │           │
  │             │                   │─persistResult()─────────────────────────▶│
  │             │                   │                │            │  INSERT   │
  │             │                   │◀── Rujukan ─────────────────────────────│
  │             │◀──ReferralProcessResult            │            │           │
  │◀─render peta─│                  │                │            │           │
  │  + ranking   │                  │                │            │           │
  │             │                  │                │            │           │
  │─klik Konfirm▶│                  │                │            │           │
  │             │─update status ────────────────────────────────────────────▶│
  │             │                   │                │            │  Observer  │
  │             │                   │                │            │  INSERT   │
  │             │                   │                │            │  riwayat  │
  │◀─redirect ──│                  │                │            │           │
```

---

## 17. Caching Strategy

| Data | Cache Key | TTL | Driver |
|---|---|---|---|
| Kandidat RS per area | `rs_candidates_{lat}_{lng}_{layanan}` | 30 menit | Redis |
| Reverse geocoding | `geocode_rev_{lat}_{lng}` | 24 jam | Redis |
| Forward geocoding | `geocode_fwd_{hash(address)}` | 24 jam | Redis |
| Layanan tersedia | `rs_layanan_list` | 1 jam | Redis |

---

## 18. Error Handling System

Project menggunakan sistem error handling **dua-level** yang terstruktur, identik dengan pattern project base:

```
           User Action
               |
         runSafely(callback)
               |
     +---------+---------+
     |                   |
BusinessException      Throwable
(Error domain —        (Error sistem —
 pesan langsung         pesan generic)
 ke user via swal)          |
                       ErrorLogger::log()
                            |
                       UUID → Laravel Log
                            |
                       "Kode: {uuid}"
                       ditampilkan ke user
```

### Error Spesifik Domain Perujukan

```php
// Contoh BusinessException untuk domain rujukan:

if ($kandidatRS->isEmpty()) {
    throw new BusinessException(
        'Tidak ada rumah sakit dengan layanan "' . $layanan . '" dalam radius ' . $radius . ' km.'
    );
}

if ($pasien->latitude === null || $pasien->longitude === null) {
    throw new BusinessException(
        'Data koordinat pasien belum diisi. Harap lengkapi profil pasien terlebih dahulu.'
    );
}
```

### Aturan Error Handling

| Situasi | Cara |
|---|---|
| Koordinat pasien kosong | `BusinessException` — pesan user-friendly |
| Tidak ada RS dalam radius | `BusinessException` — saran perluas radius |
| Error validasi form | `$this->validate()` — pesan merah otomatis |
| Error sistem (DB down, dll) | Biarkan `Throwable` — `ErrorLogger` log UUID |
| A\* gagal total | `BusinessException` — fallback saran manual |

---

## 19. Security Architecture

### Lapisan Keamanan

```
Browser
  ↓
[RemoveHeadersMiddleware]     — Hapus X-Powered-By, Server header
[throttle:high]               — Rate limiting
  ↓
[auth]                        — Session authentication (Breeze)
  ↓
[permission:xxx-yyy]          — Spatie Permission route middleware
  ↓
Handler Component             — mount() + authorize() untuk scoping data
  ↓
runSafely()                   — Exception boundary
  ↓
Eloquent ORM                  — Parameterized queries (no SQL injection)
```

### Scoping Data per Role

```php
// Dokter hanya lihat rujukan yang dia buat
// RS hanya lihat rujukan yang ditujukan ke RS mereka

public function mount(): void
{
    if (auth()->user()->hasRole('dokter')) {
        $this->query = Rujukan::where('id_user', auth()->id());
    } elseif (auth()->user()->hasRole('rumah_sakit')) {
        $this->query = Rujukan::where('id_rumah_sakit', auth()->user()->rumahSakitId);
    } else {
        $this->query = Rujukan::query(); // admin & operator: semua
    }
}
```

---

## 20. Activity Logging

### LogUserActions Middleware

Mencatat setiap request HTTP yang valid ke tabel `log_histories`:

```
Request masuk → auth check → shouldLog() check
                                    |
              +---------------------+
              | Diabaikan:          | Dicatat:
              | - livewire/*        | GET  → 'list' / 'form_create'
              | - telescope/*       | POST → 'create'
              | - horizon/*         | PUT  → 'update'
              | - ping              | DEL  → 'delete'
              +---------------------+
                    |
             DB: log_histories
             + laravel.log (secondary)
```

### RujukanObserver — Auto Audit Trail

```php
// app/Observers/RujukanObserver.php
// Otomatis INSERT riwayat_rujukan setiap kali status berubah

public function updating(Rujukan $rujukan): void
{
    if ($rujukan->isDirty('status')) {
        RiwayatRujukan::create([
            'id_rujukan'     => $rujukan->id_rujukan,
            'status_lama'    => $rujukan->getOriginal('status'),
            'status_baru'    => $rujukan->status,
            'keterangan'     => 'Status diubah via sistem',
            'diubah_oleh'    => auth()->id(),
            'waktu_perubahan'=> now(),
        ]);
    }
}
```

---

## 21. Panduan: Do & Don't

### DO — Selalu Lakukan

**Arsitektur:**
- Gunakan `Livewire full-page component` untuk SEMUA halaman (bukan HTTP Controller)
- Gunakan `HandlesErrors` trait di setiap Handler
- Bungkus operasi DB multi-langkah dengan `DB::transaction()`
- Inject service via constructor atau `app()` — jangan `new AStarService()`
- Gunakan `RujukanObserver` untuk audit trail status — jangan manual INSERT riwayat
- Gunakan Enum untuk semua status & tipe (`StatusRujukan::Disetujui`, bukan `'disetujui'`)
- Cache kandidat RS & geocoding — jangan hit Nominatim setiap request

**Kode:**
- Deklarasikan explicit return type untuk semua public method
- Gunakan typed properties (`public ?int $pasienId = null`)
- Tambah `->limit(200)` untuk query dropdown/select
- Selalu `$this->validate()` sebelum operasi DB

**Frontend:**
- Pakai `wire:navigate` untuk semua link internal
- Re-initialize Leaflet.js di event `livewire:navigated`
- Gunakan `wire:loading` untuk feedback saat A\* berjalan
- Dark mode variant (`dark:*`) di setiap class warna

### DON'T — Jangan Pernah

**Arsitektur:**
- JANGAN buat HTTP Controller biasa untuk halaman dashboard
- JANGAN store request-specific state di static property (Octane leak)
- JANGAN buat folder baru di `app/` atau `resources/` tanpa diskusi
- JANGAN install dependency baru tanpa persetujuan

**Service:**
- JANGAN panggil Nominatim API tanpa caching — ada rate limit!
- JANGAN jalankan A\* tanpa filter kandidat RS terlebih dahulu
- JANGAN simpan koordinat sebagai `string` — gunakan `float` cast

**Error Handling:**
- JANGAN try-catch di Form Object — biarkan exception naik ke `runSafely`
- JANGAN tampilkan stack trace atau detail teknis ke user
- JANGAN catch exception tanpa re-throw di service class

**Frontend:**
- JANGAN CDN untuk library utama (kecuali Tom Select)
- JANGAN blok JS inline panjang di Blade view
- JANGAN gunakan jQuery atau $.ajax

---

## 22. Behavior Rules per Layer

### Service Layer

```php
// DO — Service hanya logika bisnis, tanpa Livewire state
class AStarService
{
    // Pure function: input/output jelas, tidak ada side effect global
    public function findBestHospital(float $lat, float $lng, Collection $hospitals): AStarResult
    {
        // Hanya komputasi, tidak ada DB write, tidak ada event dispatch
    }
}

// DO — ReferralService sebagai orkestrator
class ReferralService
{
    public function processReferral(Pasien $pasien, string $layanan, User $user): ReferralProcessResult
    {
        // 1. Score → 2. A* → 3. Persist dalam satu transaksi
        return DB::transaction(function () use ($pasien, $layanan, $user) {
            $candidates = $this->scoring->getCandidates(...);  // step 1
            $result     = $this->astar->findBestHospital(...); // step 2
            $rujukan    = $this->persistResult($result, ...);  // step 3
            return new ReferralProcessResult($result, $rujukan);
        });
    }
}
```

### Model Layer

```php
// DO
class RumahSakit extends Model
{
    // Casts untuk type safety
    protected $casts = ['layanan_operasi' => 'array', 'latitude' => 'float'];

    // Query scope reusable
    public function scopeHasLayanan(Builder $query, string $layanan): Builder
    {
        return $query->whereRaw("JSON_CONTAINS(layanan_operasi, ?)", ['"'.$layanan.'"']);
    }

    // Scope radius menggunakan Haversine di DB level (untuk performa)
    public function scopeWithinRadius(Builder $query, float $lat, float $lng, int $km): Builder
    {
        return $query->selectRaw("*, (6371 * acos(
            cos(radians(?)) * cos(radians(latitude))
            * cos(radians(longitude) - radians(?))
            + sin(radians(?)) * sin(radians(latitude))
        )) AS distance", [$lat, $lng, $lat])
        ->having('distance', '<=', $km)
        ->orderBy('distance');
    }
}
```

### Handler Layer

```php
// DO — Handler orchestrate, tidak manipulasi data langsung
public function searchReferral(): void
{
    $this->validate();                    // 1. Validasi dulu

    $this->runSafely(function () {        // 2. Semua di dalam runSafely
        $result = $this->referralService  // 3. Delegasikan ke Service
            ->processReferral(...);

        $this->astarResult = $result->toArray(); // 4. Update state
        $this->dispatch('swal', ...);            // 5. Feedback
    }, 'Log message', ['context' => 'array']);   // 6. Log context
}
```

---

## 23. Panduan Tambah Domain Baru

```bash
# 1. Buat Livewire handlers
php artisan make:livewire Handler/NamaDomain/Index
php artisan make:livewire Handler/NamaDomain/Create
php artisan make:livewire Handler/NamaDomain/Edit

# 2. Buat PowerGrid table
php artisan make:livewire PowergridTables/NamaDomainTable

# 3. Buat model + factory + migration
php artisan make:model NamaDomain -mf

# 4. Tambahkan ke PermissionSeeder
# nama-domain-list, nama-domain-create, nama-domain-edit

# 5. Daftarkan route (ikuti pattern)
Route::prefix('nama-domain')->name('nama-domain.')->middleware(['auth'])->group(function () {
    Route::get('/', Handler\NamaDomain\Index::class)->name('index')->middleware('permission:nama-domain-list');
});

# 6. Tambah sidebar di config/navigation.php
['label' => 'Nama Domain', 'route' => 'nama-domain.index', 'icon' => 'icon-name',
 'guard' => ['can', 'nama-domain-list']]

# 7. Tulis test
php artisan make:test --pest NamaDomainTest
```

### Struktur Test Minimal per Domain

```php
it('dokter dapat mencari rujukan RS terdekat', function () {
    $user = User::factory()->create()->assignRole('dokter');
    $pasien = Pasien::factory()->create(['latitude' => -6.2, 'longitude' => 106.8]);
    RumahSakit::factory()->count(3)->create();

    Livewire::actingAs($user)
        ->test(Handler\Rujukan\Create::class)
        ->set('pasienId', $pasien->id_pasien)
        ->set('layanan', 'ICU')
        ->call('searchReferral')
        ->assertDispatched('swal')
        ->assertSet('astarResult', fn ($r) => $r !== null);

    expect(Rujukan::where('id_pasien', $pasien->id_pasien)->exists())->toBeTrue();
});
```

---

## Diagram Ringkas: Kapan Pakai Apa

```
Butuh halaman baru?
  → app/Livewire/Handler/{Domain}/{Action}.php
  → resources/views/livewire/handler/{domain}/{action}.blade.php

Butuh tabel data?
  → app/Livewire/PowergridTables/{Domain}Table.php

Butuh komponen peta/GPS?
  → app/Livewire/Utils/MapPicker.php

Butuh logika bisnis kompleks (A*, scoring)?
  → app/Services/{NamaService}.php

Butuh value object / hasil kalkulasi?
  → app/DTOs/{NamaResult}.php

Butuh status/tipe tidak berubah?
  → app/Enums/{NamaEnum}.php

Butuh exception dengan pesan ke user?
  → throw new BusinessException('Pesan yang ramah');

Butuh audit trail otomatis?
  → app/Observers/{NamaModel}Observer.php
```

---

*Dokumen ini dibuat berdasarkan ERD dan keputusan teknis per Agustus 2026.*
*Update dokumen ini setiap kali ada perubahan arsitektural yang signifikan.*
