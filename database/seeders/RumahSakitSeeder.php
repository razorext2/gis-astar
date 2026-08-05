<?php

namespace Database\Seeders;

use App\Models\RumahSakit;
use Illuminate\Database\Seeder;

/**
 * Seeder data rumah sakit dengan koordinat nyata di Jakarta dan sekitarnya.
 * Data ini digunakan untuk testing dan development.
 */
class RumahSakitSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_rumah_sakit' => 'RSUP Dr. Cipto Mangunkusumo',
                'alamat' => 'Jl. Diponegoro No.71, Kenari, Senen, Jakarta Pusat',
                'no_telepon' => '02119216382',
                'latitude' => -6.1924,
                'longitude' => 106.8456,
                'layanan_operasi' => ['IGD', 'ICU', 'NICU', 'Bedah', 'Jantung', 'Saraf', 'Kebidanan', 'Anak'],
            ],
            [
                'nama_rumah_sakit' => 'RS Fatmawati',
                'alamat' => 'Jl. RS Fatmawati Raya, Cilandak, Jakarta Selatan',
                'no_telepon' => '02175902777',
                'latitude' => -6.2914,
                'longitude' => 106.7961,
                'layanan_operasi' => ['IGD', 'ICU', 'Bedah', 'Penyakit Dalam', 'Kebidanan', 'Anak', 'Radiologi'],
            ],
            [
                'nama_rumah_sakit' => 'RS Persahabatan',
                'alamat' => 'Jl. Persahabatan Raya No.1, Rawamangun, Jakarta Timur',
                'no_telepon' => '0214891708',
                'latitude' => -6.1955,
                'longitude' => 106.8944,
                'layanan_operasi' => ['IGD', 'ICU', 'Bedah', 'Penyakit Dalam', 'Jantung', 'Radiologi'],
            ],
            [
                'nama_rumah_sakit' => 'RS Tarakan Jakarta',
                'alamat' => 'Jl. Kyai Caringin No.7, Gambir, Jakarta Pusat',
                'no_telepon' => '0213510068',
                'latitude' => -6.1627,
                'longitude' => 106.8146,
                'layanan_operasi' => ['IGD', 'ICU', 'Bedah', 'Penyakit Dalam', 'Saraf', 'Anak'],
            ],
            [
                'nama_rumah_sakit' => 'RS Pasar Rebo',
                'alamat' => 'Jl. TB Simatupang No.30, Pasar Rebo, Jakarta Timur',
                'no_telepon' => '02187781837',
                'latitude' => -6.3012,
                'longitude' => 106.8722,
                'layanan_operasi' => ['IGD', 'ICU', 'Bedah', 'Kebidanan', 'Anak', 'Radiologi'],
            ],
            [
                'nama_rumah_sakit' => 'RS Bhayangkara Jakarta',
                'alamat' => 'Jl. Kesehatan No.27, Kramat, Jakarta Pusat',
                'no_telepon' => '0214244131',
                'latitude' => -6.1879,
                'longitude' => 106.8518,
                'layanan_operasi' => ['IGD', 'ICU', 'Bedah', 'Penyakit Dalam', 'Radiologi'],
            ],
            [
                'nama_rumah_sakit' => 'RS Sumber Waras',
                'alamat' => 'Jl. Kyai Tapa No.1, Grogol, Jakarta Barat',
                'no_telepon' => '0215673903',
                'latitude' => -6.1671,
                'longitude' => 106.7973,
                'layanan_operasi' => ['IGD', 'ICU', 'NICU', 'Bedah', 'Jantung', 'Kebidanan', 'Anak'],
            ],
            [
                'nama_rumah_sakit' => 'RS Haji Jakarta',
                'alamat' => 'Jl. Raya Pondok Gede No.4, Kramatjati, Jakarta Timur',
                'no_telepon' => '0218003344',
                'latitude' => -6.2761,
                'longitude' => 106.9003,
                'layanan_operasi' => ['IGD', 'ICU', 'Bedah', 'Penyakit Dalam', 'Saraf', 'Kebidanan'],
            ],
            [
                'nama_rumah_sakit' => 'RSUD Tangerang',
                'alamat' => 'Jl. Jend. A. Yani No.9, Kota Tangerang, Banten',
                'no_telepon' => '0215521280',
                'latitude' => -6.1786,
                'longitude' => 106.6279,
                'layanan_operasi' => ['IGD', 'ICU', 'Bedah', 'Penyakit Dalam', 'Kebidanan', 'Anak', 'Radiologi'],
            ],
            [
                'nama_rumah_sakit' => 'RSUD Bekasi',
                'alamat' => 'Jl. Pramuka No.55, Bekasi Kota',
                'no_telepon' => '0218831890',
                'latitude' => -6.2349,
                'longitude' => 107.0100,
                'layanan_operasi' => ['IGD', 'ICU', 'NICU', 'Bedah', 'Jantung', 'Kebidanan', 'Anak'],
            ],
            [
                'nama_rumah_sakit' => 'RS Depok',
                'alamat' => 'Jl. Raya Sawangan No.2, Depok, Jawa Barat',
                'no_telepon' => '0217520082',
                'latitude' => -6.3823,
                'longitude' => 106.8205,
                'layanan_operasi' => ['IGD', 'ICU', 'Bedah', 'Penyakit Dalam', 'Saraf', 'Radiologi'],
            ],
            [
                'nama_rumah_sakit' => 'RS Siloam Kebon Jeruk',
                'alamat' => 'Jl. Perjuangan No.8, Kebon Jeruk, Jakarta Barat',
                'no_telepon' => '02153677888',
                'latitude' => -6.1892,
                'longitude' => 106.7646,
                'layanan_operasi' => ['IGD', 'ICU', 'NICU', 'Bedah', 'Jantung', 'Saraf', 'Kebidanan', 'Anak', 'Radiologi'],
            ],
        ];

        foreach ($data as $rs) {
            RumahSakit::firstOrCreate(
                ['nama_rumah_sakit' => $rs['nama_rumah_sakit']],
                $rs
            );
        }

        $this->command->info('✅ RumahSakitSeeder: '.count($data).' RS berhasil diseed.');
    }
}
