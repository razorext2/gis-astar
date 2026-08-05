### Core Tables:
- **users**: Akun Pengguna Sistem (id, name, email, profile_pic, is_active)
- **settings**: Pengaturan Sistem (id, key, value, group, type)

### GIS & Pathfinding Tables:
- **hospitals**: Daftar Rumah Sakit Rujukan (id, name, address, latitude, longitude, phone, class['A','B','C','D'], bpjs_partner[0=tidak, 1=mitra])
- **eye_diseases**: Jenis Penyakit/Spesialisasi Mata (id, name, description)
- **hospital_specialties**: Relasi Spesialisasi Rumah Sakit (hospital_id→hospitals.id, eye_disease_id→eye_diseases.id, is_supported[0=tidak, 1=ya])
- **nodes**: Titik/Persimpangan Koordinat GIS (id, name, latitude, longitude, type['intersection','hospital','puskesmas','patient'])
- **roads**: Ruas Jalan / Jalur Penghubung Graf A* (id, node_from→nodes.id, node_to→nodes.id, distance_meters, travel_time_seconds, average_speed, road_name)
- **referrals**: Riwayat Rekomendasi Rujukan Pasien (id, patient_name, eye_disease_id→eye_diseases.id, origin_node_id→nodes.id, target_hospital_id→hospitals.id, calculated_distance, path_nodes [json/text], search_date)
