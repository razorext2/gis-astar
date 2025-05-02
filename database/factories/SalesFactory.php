<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales>
 */
class SalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_pegawai' => '28101999',
            'title' => fake()->sentence(2),
            'customer_name' => fake()->name(),
            'customer_telp' => fake()->phoneNumber(),
            'lokasi' => fake()->address(),
            'keterangan' => fake()->sentence(5),
            'longitude' => fake()->longitude(),
            'latitude' => fake()->latitude(),
        ];
    }
}
