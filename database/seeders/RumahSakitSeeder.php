<?php

namespace Database\Seeders;

use App\Models\RumahSakit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder data rumah sakit mata rujukan di Kota Medan, Sumatera Utara.
 * Sumber: data lapangan SIPROMATA.
 */
class RumahSakitSeeder extends Seeder
{
    public function run(): void
    {
        $layananMata = ['Operasi Katarak', 'Operasi Glaukoma', 'Operasi Retina', 'Operasi Kornea', 'Poliklinik Mata', 'IGD Mata'];

        $data = [
            [
                'nama_rumah_sakit' => 'Rumah Sakit Mata SMEC Medan',
                'alamat' => 'Jl. Iskandar Muda No.278-280, Petisah Tengah, Kec. Medan Petisah, Kota Medan, Sumatera Utara 20112',
                'no_telepon' => '08041227788',
                'latitude' => 3.5872,
                'longitude' => 98.6588151,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'RS Mata Prima Vision',
                'alamat' => 'Jl. Pabrik Tenun No.51, RW.53, Sei Putih Tengah, Kec. Medan Petisah, Kota Medan, Sumatera Utara 20114',
                'no_telepon' => '06180514888',
                'latitude' => 3.598363,
                'longitude' => 98.6568685,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'RS Mata Mencirim',
                'alamat' => 'Jl. Sei Mencirim No.77, Babura, Kec. Medan Baru, Kota Medan, Sumatera Utara 20154',
                'no_telepon' => '0614522886',
                'latitude' => 3.5806573,
                'longitude' => 98.6518257,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'Medan Eye Centre',
                'alamat' => 'Jl. Ir. H. Juanda No.1, Anggrung, Kec. Medan Polonia, Kota Medan, Sumatera Utara 20151',
                'no_telepon' => '0614536657',
                'latitude' => 3.5745354,
                'longitude' => 98.6681003,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'Eye Wellness Medan',
                'alamat' => 'Jl. Gaharu No.12, Gaharu, Kec. Medan Tim., Kota Medan, Sumatera Utara 20235',
                'no_telepon' => '085175478383',
                'latitude' => 3.5989213,
                'longitude' => 98.6751988,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'RS Khusus Mata Medan Baru',
                'alamat' => 'Jl. Abdullah Lubis No.67, Merdeka, Kec. Medan Baru, Kota Medan, Sumatera Utara 20222',
                'no_telepon' => '082276739545',
                'latitude' => 3.5766436,
                'longitude' => 98.6561872,
                'layanan_operasi' => $layananMata,
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        RumahSakit::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach ($data as $rs) {
            RumahSakit::create($rs);
        }

        $this->command->info('? RumahSakitSeeder: '.count($data).' RS Mata Medan berhasil diseed.');
    }
}
