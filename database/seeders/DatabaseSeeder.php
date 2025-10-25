<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        \App\Models\User::factory()->create([
            'name' => 'G-Track Admin',
            'email' => 'admin@g-track.eu',
            'password' => bcrypt('password123'),
        ]);

        // Seed drivers with documents
        $this->call([
            DriversTableSeeder::class,
        ]);
    }
}
