<?php

namespace Database\Seeders;

use App\Enums\JenisKelamin;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeder data pasien dengan koordinat di area Kota Medan, Sumatera Utara.
 */
class PasienSeeder extends Seeder
{
    public function run(): void
    {
        $dokter = User::whereHas('roles', fn ($q) => $q->where('name', 'Dokter'))->first()
            ?? User::first();

        $pasienData = [
            [
                'nik' => '1271010101850001',
                'no_rm' => 'RM-000001',
                'nama' => 'Andi Saputra',
                'jenis_kelamin' => JenisKelamin::LakiLaki,
                'tanggal_lahir' => '1985-01-01',
                'alamat' => 'Jl. Setia Budi No.12, Medan Sunggal',
                'no_telepon' => '081234567801',
                'latitude' => 3.5820,
                'longitude' => 98.6490,
            ],
            [
                'nik' => '1271020202900002',
                'no_rm' => 'RM-000002',
                'nama' => 'Siti Aisyah',
                'jenis_kelamin' => JenisKelamin::Perempuan,
                'tanggal_lahir' => '1990-02-02',
                'alamat' => 'Jl. Gatot Subroto No.55, Medan Petisah',
                'no_telepon' => '081234567802',
                'latitude' => 3.5960,
                'longitude' => 98.6620,
            ],
            [
                'nik' => '1271030303750003',
                'no_rm' => 'RM-000003',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => JenisKelamin::LakiLaki,
                'tanggal_lahir' => '1975-03-03',
                'alamat' => 'Jl. Imam Bonjol No.18, Medan Barat',
                'no_telepon' => '081234567803',
                'latitude' => 3.5932,
                'longitude' => 98.6845,
            ],
            [
                'nik' => '1271040404880004',
                'no_rm' => 'RM-000004',
                'nama' => 'Dewi Lestari',
                'jenis_kelamin' => JenisKelamin::Perempuan,
                'tanggal_lahir' => '1988-04-04',
                'alamat' => 'Jl. Monginsidi No.7, Medan Baru',
                'no_telepon' => '081234567804',
                'latitude' => 3.5750,
                'longitude' => 98.6780,
            ],
            [
                'nik' => '1271050505920005',
                'no_rm' => 'RM-000005',
                'nama' => 'Rizky Pratama',
                'jenis_kelamin' => JenisKelamin::LakiLaki,
                'tanggal_lahir' => '1992-05-05',
                'alamat' => 'Jl. Diponegoro No.30, Medan Maimun',
                'no_telepon' => '081234567805',
                'latitude' => 3.5710,
                'longitude' => 98.6890,
            ],
            [
                'nik' => '1271060606800006',
                'no_rm' => 'RM-000006',
                'nama' => 'Rina Wahyuni',
                'jenis_kelamin' => JenisKelamin::Perempuan,
                'tanggal_lahir' => '1980-06-06',
                'alamat' => 'Jl. Sudirman No.45, Medan Kota',
                'no_telepon' => '081234567806',
                'latitude' => 3.5880,
                'longitude' => 98.6930,
            ],
            [
                'nik' => '1271070707930007',
                'no_rm' => 'RM-000007',
                'nama' => 'Hendra Gunawan',
                'jenis_kelamin' => JenisKelamin::LakiLaki,
                'tanggal_lahir' => '1993-07-07',
                'alamat' => 'Jl. HM Yamin No.22, Medan Timur',
                'no_telepon' => '081234567807',
                'latitude' => 3.6005,
                'longitude' => 98.7020,
            ],
            [
                'nik' => '1271080808870008',
                'no_rm' => 'RM-000008',
                'nama' => 'Maya Sari',
                'jenis_kelamin' => JenisKelamin::Perempuan,
                'tanggal_lahir' => '1987-08-08',
                'alamat' => 'Jl. Pancing No.11, Medan Tembung',
                'no_telepon' => '081234567808',
                'latitude' => 3.6085,
                'longitude' => 98.7150,
            ],
            [
                'nik' => '1271090909820009',
                'no_rm' => 'RM-000009',
                'nama' => 'Fajar Nugroho',
                'jenis_kelamin' => JenisKelamin::LakiLaki,
                'tanggal_lahir' => '1982-09-09',
                'alamat' => 'Jl. Karya No.5, Medan Helvetia',
                'no_telepon' => '081234567809',
                'latitude' => 3.6150,
                'longitude' => 98.6550,
            ],
            [
                'nik' => '1271101010950010',
                'no_rm' => 'RM-000010',
                'nama' => 'Putri Handayani',
                'jenis_kelamin' => JenisKelamin::Perempuan,
                'tanggal_lahir' => '1995-10-10',
                'alamat' => 'Jl. Brigjend Katamso No.8, Medan Polonia',
                'no_telepon' => '081234567810',
                'latitude' => 3.5680,
                'longitude' => 98.6720,
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Pasien::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach ($pasienData as $p) {
            Pasien::create(array_merge($p, ['id_user' => $dokter?->id]));
        }

        $this->command->info('? PasienSeeder: '.count($pasienData).' pasien Medan berhasil diseed.');
    }
}
