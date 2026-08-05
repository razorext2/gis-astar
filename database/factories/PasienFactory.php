<?php

namespace Database\Factories;

use App\Enums\JenisKelamin;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PasienFactory extends Factory
{
    protected $model = Pasien::class;

    public function definition(): array
    {
        // Koordinat area Jabodetabek
        $lat = $this->faker->latitude(-6.4, -6.1);
        $lng = $this->faker->longitude(106.7, 107.0);

        return [
            'id_user' => User::factory(),
            'nik' => $this->faker->unique()->numerify('################'),
            'no_rm' => 'RM-'.$this->faker->unique()->numerify('######'),
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement([JenisKelamin::LakiLaki->value, JenisKelamin::Perempuan->value]),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-70 years', '-1 year'),
            'alamat' => $this->faker->address(),
            'no_telepon' => '08'.$this->faker->numerify('##########'),
            'latitude' => $lat,
            'longitude' => $lng,
        ];
    }

    /** State: pasien tanpa koordinat (untuk test edge case) */
    public function withoutCoordinates(): static
    {
        return $this->state(fn () => ['latitude' => null, 'longitude' => null]);
    }
}
