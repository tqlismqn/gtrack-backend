<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@g-track.eu',
            'password' => bcrypt('password123'),
        ]);

        $this->call(DriversTableSeeder::class);
    }
}
