<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        
        $this->call([
            DriversTableSeeder::class,
        ]);

        $this->command->info('✅ Database seeding completed!');
    }
}
