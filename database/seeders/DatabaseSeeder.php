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
        \App\Models\User::factory()->create([
            'name' => 'G-Track Admin',
            'email' => 'admin@g-track.eu',
            'password' => bcrypt('password123'),
        ]);

        $this->call([
            DriversTableSeeder::class,
        ]);

        $this->command?->info('✅ All seeders completed!');
    }
}
