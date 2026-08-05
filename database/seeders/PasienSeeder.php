<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        // Hubungkan pasien dengan user dokter yang ada
        $dokter = User::whereHas('roles', fn ($q) => $q->where('name', 'dokter'))->first()
            ?? User::first();

        // 5 Pasien dummy di area Jakarta
        $pasienData = [
            [
                'nik' => '3171012345670001',
                'no_rm' => 'RM-000001',
                'nama' => 'Budi Sudarsono',
                'jenis_kelamin' => 'laki_laki',
                'tanggal_lahir' => '1985-05-12',
                'alamat' => 'Senen, Jakarta Pusat',
                'no_telepon' => '081234567890',
                'latitude' => -6.1944,
                'longitude' => 106.8444,
            ],
            [
                'nik' => '3172023456780002',
                'no_rm' => 'RM-000002',
                'nama' => 'Siti Aminah',
                'jenis_kelamin' => 'perempuan',
                'tanggal_lahir' => '1990-08-20',
                'alamat' => 'Rawamangun, Jakarta Timur',
                'no_telepon' => '081345678901',
                'latitude' => -6.1975,
                'longitude' => 106.8922,
            ],
            [
                'nik' => '3173034567890003',
                'no_rm' => 'RM-000003',
                'nama' => 'Andi Wijaya',
                'jenis_kelamin' => 'laki_laki',
                'tanggal_lahir' => '1978-03-15',
                'alamat' => 'Grogol, Jakarta Barat',
                'no_telepon' => '081456789012',
                'latitude' => -6.1666,
                'longitude' => 106.7900,
            ],
            [
                'nik' => '3174045678900004',
                'no_rm' => 'RM-000004',
                'nama' => 'Dewi Lestari',
                'jenis_kelamin' => 'perempuan',
                'tanggal_lahir' => '1995-11-22',
                'alamat' => 'Cilandak, Jakarta Selatan',
                'no_telepon' => '081567890123',
                'latitude' => -6.2900,
                'longitude' => 106.7922,
            ],
            [
                'nik' => '3175056789010005',
                'no_rm' => 'RM-000005',
                'nama' => 'Eko Prasetyo',
                'jenis_kelamin' => 'laki_laki',
                'tanggal_lahir' => '1988-01-30',
                'alamat' => 'Pasar Rebo, Jakarta Timur',
                'no_telepon' => '081678901234',
                'latitude' => -6.3050,
                'longitude' => 106.8700,
            ],
        ];

        foreach ($pasienData as $p) {
            Pasien::firstOrCreate(
                ['nik' => $p['nik']],
                array_merge($p, ['id_user' => $dokter?->id])
            );
        }
    }
}
