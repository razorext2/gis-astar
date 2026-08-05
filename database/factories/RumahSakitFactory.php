<?php

namespace Database\Factories;

use App\Models\RumahSakit;
use Illuminate\Database\Eloquent\Factories\Factory;

class RumahSakitFactory extends Factory
{
    protected $model = RumahSakit::class;

    private array $layananPool = ['IGD', 'ICU', 'NICU', 'Bedah', 'Penyakit Dalam', 'Jantung', 'Saraf', 'Kebidanan', 'Anak', 'Radiologi'];

    public function definition(): array
    {
        $lat = $this->faker->latitude(-6.4, -6.1);
        $lng = $this->faker->longitude(106.7, 107.0);
        $layanan = $this->faker->randomElements($this->layananPool, $this->faker->numberBetween(3, 7));

        return [
            'nama_rumah_sakit' => 'RS '.$this->faker->company(),
            'alamat' => $this->faker->address(),
            'no_telepon' => '021'.$this->faker->numerify('#######'),
            'latitude' => $lat,
            'longitude' => $lng,
            'layanan_operasi' => array_values($layanan),
        ];
    }
}
