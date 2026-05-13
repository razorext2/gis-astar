<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tb_jabatan')->insert([
            [
                'nama_jabatan' => 'Software Developer',
                'divisi' => 11,
                'penempatan' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Teknisi Hardware',
                'divisi' => 11,
                'penempatan' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jabatan' => 'Staff Marketing',
                'divisi' => 7,
                'penempatan' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
