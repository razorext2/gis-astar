<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@email.com'],
            [
                'name' => 'Dummy User',
                'password' => Hash::make('admin123'),
                'is_active' => true,
            ]
        );
    }
}
