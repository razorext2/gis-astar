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
                'alamat' => 'Jl. Setia Budi No.117, Tanjung Rejo, Medan Sunggal, Kota Medan',
                'no_telepon' => '0618220082',
                'latitude' => 3.5870,
                'longitude' => 98.6437,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'RS Mata Prima Vision',
                'alamat' => 'Jl. Gatot Subroto No.395, Sei Sikambing B, Medan Petisah, Kota Medan',
                'no_telepon' => '0618442525',
                'latitude' => 3.5985,
                'longitude' => 98.6610,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'RS Mata Mencirim',
                'alamat' => 'Jl. Mencirim No.3, Babura, Medan Baru, Kota Medan',
                'no_telepon' => '0614155200',
                'latitude' => 3.5778,
                'longitude' => 98.6804,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'Medan Eye Centre',
                'alamat' => 'Jl. Iskandar Muda No.45, Petisah Tengah, Medan Petisah, Kota Medan',
                'no_telepon' => '0614561823',
                'latitude' => 3.5950,
                'longitude' => 98.6740,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'Eye Wellness Medan',
                'alamat' => 'Jl. Pemuda No.10, Kesawan, Medan Barat, Kota Medan',
                'no_telepon' => '0614538800',
                'latitude' => 3.5891,
                'longitude' => 98.6820,
                'layanan_operasi' => $layananMata,
            ],
            [
                'nama_rumah_sakit' => 'RS Khusus Mata Medan Baru',
                'alamat' => 'Jl. Pattimura No.62, Babura, Medan Baru, Kota Medan',
                'no_telepon' => '0614529111',
                'latitude' => 3.5802,
                'longitude' => 98.6870,
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
