# Checkpoint — GIS-Astar Implementation Progress

> File ini digunakan untuk melacak progress implementasi sistem perujukan otomatis A*.
> Update status setiap kali sebuah tahap selesai dikerjakan.

**Legend:**
- `[ ]` — Belum dikerjakan
- `[/]` — Sedang dikerjakan
- `[x]` — Selesai

> **Progress terkini:** Semua Tahap (1–9) telah SELESAI dikerjakan dengan hasil pengujian 100% PASS dan formatting Laravel Pint bersih.

---

## Tahap 1 — Foundation: Enums, DTOs, Migrations

> Fondasi data layer: schema database + type-safe enums + value objects.

- [x] **Enum** `StatusRujukan` (`pending`, `disetujui`, `ditolak`, `selesai`)
- [x] **Enum** `TipeTitikRute` (`awal`, `perantara`, `tujuan`)
- [x] **Enum** `MetodeRujukan` (`manual`, `otomatis`)
- [x] **Enum** `JenisKelamin` (`laki_laki`, `perempuan`)
- [x] **DTO** `GeoPoint` `{lat, lng, label, tipe}`
- [x] **DTO** `AStarResult`
- [x] **DTO** `ReferralProcessResult`
- [x] **Migration** `create_pasien_table`
- [x] **Migration** `create_rumah_sakit_rujukan_table`
- [x] **Migration** `create_rujukan_table`
- [x] **Migration** `create_detail_rujukan_table`
- [x] **Migration** `create_rute_table`
- [x] **Migration** `create_titik_rute_table`
- [x] **Migration** `create_riwayat_rujukan_table`

**Status:** ✅ SELESAI

---

## Tahap 2 — Domain Layer: Models & Observer

> Model Eloquent dengan relasi, scope, cast, dan observer untuk audit trail.

- [x] **Model** `Pasien` (belongsTo User, hasMany Rujukan)
- [x] **Model** `RumahSakit` (JSON cast layanan, scopeHasLayanan, scopeWithinRadius)
- [x] **Model** `Rujukan` (Enum cast StatusRujukan, hasOne DetailRujukan, hasMany RiwayatRujukan)
- [x] **Model** `DetailRujukan` (belongsTo Rujukan, belongsTo Rute)
- [x] **Model** `Rute` (hasMany TitikRute)
- [x] **Model** `TitikRute` (Enum cast TipeTitikRute)
- [x] **Model** `RiwayatRujukan` (belongsTo Rujukan, belongsTo User)
- [x] **Observer** `RujukanObserver` (auto INSERT riwayat_rujukan saat status berubah)
- [x] Daftarkan Observer di `AppServiceProvider`

**Status:** ✅ SELESAI

---

## Tahap 3 — Application Layer: Services

> Implementasi logika bisnis: algoritma A*, scoring RS, geocoding, dan orkestrator.

- [x] **Service** `AStarService` (Haversine, findBestHospital, estimateTime, estimateCost)
- [x] **Service** `HospitalScoringService` (getCandidates, JSON_CONTAINS, radius filter)
- [x] **Service** `GeocodingService` (Nominatim reverse geocoding, Redis cache)
- [x] **Service** `ReferralService` (orkestrator: scoring → A* → persist dalam transaction)
- [x] Bind services di `AppServiceProvider`

**Status:** ✅ SELESAI

---

## Tahap 4 — Seeder & Factory

> Data dummy untuk development dan testing.

- [x] **Factory** `PasienFactory` (dengan koordinat Jakarta area)
- [x] **Factory** `RumahSakitFactory` (dengan JSON layanan_operasi)
- [x] **Seeder** `RumahSakitSeeder` (10+ RS dummy dengan koordinat nyata)
- [x] **Seeder** `PasienSeeder` (5 pasien dummy)
- [x] **Seeder** `RolePermissionSeeder` — tambahkan permission & role baru
- [x] Daftarkan di `DatabaseSeeder`

**Status:** ✅ SELESAI

---

## Tahap 5 — Livewire Handlers: Pasien & Rumah Sakit (CRUD)

> CRUD operasi untuk manajemen data master.

- [x] **Handler** `Pasien\Index` (PowerGrid table)
- [x] **Handler** `Pasien\Create` (form + MapPicker inline)
- [x] **Handler** `Pasien\Edit`
- [x] **PowerGrid** `PasienTable`
- [x] **Handler** `RumahSakit\Index` (PowerGrid table)
- [x] **Handler** `RumahSakit\Create` (form + JSON layanan builder)
- [x] **Handler** `RumahSakit\Edit`
- [x] **PowerGrid** `RumahSakitTable`
- [x] Blade views untuk semua Handler di atas
- [x] Routes untuk Pasien & RumahSakit di `web.php`
- [x] Sidebar navigation entry di `config/navigation.php`

**Status:** ✅ SELESAI

---

## Tahap 6 — Livewire Handlers: Rujukan + A* Engine

> Inti sistem: form perujukan dengan integrasi A*, hasil peta, dan konfirmasi.

- [x] **Handler** `Rujukan\Index` (PowerGrid table + filter status)
- [x] **Handler** `Rujukan\Create` (form + A* trigger synchronous + hasil ranking)
- [x] **Handler** `Rujukan\Show` (detail rujukan + peta Leaflet + rute)
- [x] **Handler** `Rujukan\UpdateStatus` (setuju/tolak/selesai)
- [x] **PowerGrid** `RujukanTable`
- [x] Blade views untuk semua Handler rujukan
- [x] Routes untuk Rujukan di `web.php`
- [x] Sidebar navigation entry

**Status:** ✅ SELESAI

---

## Tahap 7 — Frontend: Leaflet.js + MapPicker Utility

> Komponen peta interaktif dengan GPS detection dan pratinjau rute.

- [x] Install `leaflet` via npm
- [x] **Livewire Utils** `MapPicker` (manual input + GPS button + marker draggable)
- [x] **Livewire Utils** `RutePreview` (polyline + markers RS + pasien)
- [x] `resources/js/utils/map.js` (GPS detect helper, Leaflet init, polyline draw)
- [x] Blade views untuk MapPicker & RutePreview
- [x] Integrasi `livewire:navigated` re-init di `main.js`

**Status:** ✅ SELESAI

---

## Tahap 8 — Testing

> Pest feature tests untuk domain utama.

- [x] **Test** `AStarServiceTest` (unit: haversine, findBestHospital, ranking)
- [x] **Test** `HospitalScoringServiceTest` (getCandidates, JSON_CONTAINS filter)
- [x] **Test** `ReferralProcessTest` (full flow: pilih pasien → A* → rujukan tersimpan)
- [x] **Test** `PasienCrudTest` (index, create, edit)
- [x] **Test** `RumahSakitCrudTest` (index, create, edit)
- [x] Run `php artisan test`

**Status:** ✅ SELESAI

---

## Tahap 9 — Verifikasi Manual & Polish

> Verifikasi end-to-end dan perbaikan UI/UX.

- [x] Run `php artisan migrate:fresh --seed`
- [x] Login sebagai dokter, coba buat rujukan end-to-end
- [x] Verifikasi peta muncul dengan benar (OSM tiles)
- [x] Verifikasi GPS detect bekerja di browser
- [x] Verifikasi ranking RS tampil sesuai jarak
- [x] Verifikasi `riwayat_rujukan` terupdate saat status berubah
- [x] Verifikasi `rute` + `titik_rute` tersimpan dengan benar
- [x] Cek kasus edge: pasien tanpa koordinat → error user-friendly
- [x] Cek kasus edge: tidak ada RS dalam radius → error user-friendly
- [x] Run `vendor/bin/pint --dirty` sebelum commit

**Status:** ✅ SELESAI

---

## Ringkasan Progress

| Tahap | Nama | Status |
|---|---|:---:|
| 1 | Foundation: Enums, DTOs, Migrations | ✅ |
| 2 | Domain Layer: Models & Observer | ✅ |
| 3 | Application Layer: Services | ✅ |
| 4 | Seeder & Factory | ✅ |
| 5 | Livewire CRUD: Pasien & RS | ✅ |
| 6 | Livewire Rujukan + A* Engine | ✅ |
| 7 | Frontend: Leaflet + MapPicker | ✅ |
| 8 | Testing | ✅ |
| 9 | Verifikasi & Polish | ✅ |

---

*Terakhir diupdate: Tahap 9 — Selesai.*
