<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ResetDemoData extends Command
{
    protected $signature = 'demo:reset';
    protected $description = 'Reset database and seed with demo data';

    public function handle(): int
    {
        $this->info('🔄 Resetting database...');

        // Drop all tables
        $this->info('Dropping tables...');
        Artisan::call('migrate:fresh', ['--force' => true]);
        
        $this->info('✅ Tables dropped and recreated');

        // Run seeders
        $this->info('Seeding database...');
        Artisan::call('db:seed', ['--force' => true]);
        
        $this->info('✅ Database seeded');

        // Verify data
        $driverCount = DB::table('drivers')->count();
        $this->info("📊 Total drivers: {$driverCount}");

        if ($driverCount === 0) {
            $this->error('❌ No drivers found after seeding!');
            return Command::FAILURE;
        }

        $this->info('✅ Demo data reset complete!');
        return Command::SUCCESS;
    }
}
