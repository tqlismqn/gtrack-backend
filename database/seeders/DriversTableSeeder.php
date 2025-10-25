<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚗 Creating 25 demo drivers...');

        // Demo driver names (Czech names)
        $driverNames = [
            ['Jan', 'Novák', null],
            ['Petr', 'Svoboda', 'Josef'],
            ['Pavel', 'Novotný', null],
            ['Jiří', 'Dvořák', 'Milan'],
            ['Josef', 'Černý', null],
            ['Tomáš', 'Procházka', 'Pavel'],
            ['Martin', 'Kučera', null],
            ['Miroslav', 'Veselý', 'Jan'],
            ['Jaroslav', 'Horák', null],
            ['Zdeněk', 'Němec', 'Petr'],
            ['Václav', 'Marek', null],
            ['Michal', 'Pospíšil', 'Tomáš'],
            ['František', 'Hájek', null],
            ['Ladislav', 'Jelínek', 'Martin'],
            ['Milan', 'Král', null],
            ['Vlastimil', 'Beneš', 'Jiří'],
            ['Stanislav', 'Fiala', null],
            ['Roman', 'Sedláček', 'Josef'],
            ['Karel', 'Doležal', null],
            ['Jindřich', 'Novák', 'Pavel'],
            ['Oldřich', 'Krejčí', null],
            ['Rudolf', 'Horáček', 'Jan'],
            ['Igor', 'Kopecký', null],
            ['Lubomír', 'Urban', 'Petr'],
            ['Rostislav', 'Vaněk', null],
        ];

        $cities = ['Praha', 'Kladno', 'Beroun', 'Rakovník', 'Slaný'];
        $countries = ['CZ', 'SK', 'PL', 'UA', 'RO'];

        foreach ($driverNames as $index => $name) {
            $driverId = Str::uuid();
            $city = $cities[array_rand($cities)];
            $country = $countries[array_rand($countries)];
            
            $hireDate = Carbon::now()->subMonths(rand(6, 60));
            $birthDate = Carbon::now()->subYears(rand(25, 60));

            // Create driver
            DB::table('drivers')->insert([
                'id' => $driverId,
                'internal_number' => $index + 1,
                'first_name' => $name[0],
                'last_name' => $name[1],
                'middle_name' => $name[2],
                'birth_date' => $birthDate->toDateString(),
                'citizenship' => $country,
                'rodne_cislo' => $country === 'CZ' ? $this->generateRodneCislo($birthDate) : null,
                'email' => strtolower($name[0] . '.' . $name[1] . '@driver.g-track.eu'),
                'phone' => '+420' . rand(600000000, 799999999),
                'reg_address' => sprintf('%s %d, %s, %s', 
                    ['Hlavní', 'Nová', 'Krátká', 'Dlouhá', 'Střední'][array_rand(['Hlavní', 'Nová', 'Krátká', 'Dlouhá', 'Střední'])],
                    rand(1, 150),
                    rand(10000, 99999),
                    $city
                ),
                'res_address' => null,
                'status' => ['active', 'active', 'active', 'on_leave'][array_rand(['active', 'active', 'active', 'on_leave'])],
                'hire_date' => $hireDate->toDateString(),
                'fire_date' => null,
                'contract_from' => $hireDate->toDateString(),
                'contract_to' => null,
                'contract_indefinite' => true,
                'work_location' => ['praha', 'kladno'][array_rand(['praha', 'kladno'])],
                'bank_country' => 'CZ',
                'bank_account' => rand(1000000000, 9999999999) . '/0100',
                'iban' => 'CZ' . rand(10, 99) . '0100' . rand(1000000000, 9999999999),
                'swift' => 'KOMBCZPP',
                'flags' => json_encode([
                    'pas_souhlas' => (bool)rand(0, 1),
                    'propiska_cz' => $country === 'CZ',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create documents for each driver
            $this->createDocuments($driverId);
        }

        $this->command->info('✅ Created 25 drivers with documents');
    }

    /**
     * Create documents for a driver
     */
    private function createDocuments(string $driverId): void
    {
        $documentTypes = [
            'passport', 'visa', 'residence', 'licence', 
            'a1_eu', 'a1_switzerland', 'declaration',
            'pojisteni', 'cestovni_pojisteni', 
            'drivers_licence', 'adr', 'chip', 
            'kod_95', 'prohlidka'
        ];

        foreach ($documentTypes as $index => $type) {
            $daysOffset = rand(-30, 365); // Some expired, some valid, some expiring soon
            $expiryDate = Carbon::now()->addDays($daysOffset);
            $issueDate = $expiryDate->copy()->subYears(rand(1, 3));

            // Determine status based on days until expiry
            if ($daysOffset < 0) {
                $status = 'expired';
            } elseif ($daysOffset <= 30) {
                $status = 'expiring_soon';
            } elseif ($daysOffset <= 60) {
                $status = 'warning';
            } else {
                $status = 'valid';
            }

            // Random chance of no data
            if (rand(1, 10) === 1) {
                $status = 'no_data';
                $expiryDate = null;
                $issueDate = null;
            }

            DB::table('driver_documents')->insert([
                'id' => Str::uuid(),
                'driver_id' => $driverId,
                'type' => $type,
                'number' => $status !== 'no_data' ? strtoupper(Str::random(8)) : null,
                'country' => $status !== 'no_data' ? 'CZ' : null,
                'from' => $issueDate?->toDateString(),
                'to' => $expiryDate?->toDateString(),
                'status' => $status,
                'days_until_expiry' => $daysOffset > 0 ? $daysOffset : null,
                'meta' => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Generate fake rodné číslo
     */
    private function generateRodneCislo(Carbon $birthDate): string
    {
        $year = $birthDate->format('y');
        $month = $birthDate->format('m');
        $day = $birthDate->format('d');
        
        return sprintf('%s%s%s/%04d', $year, $month, $day, rand(1000, 9999));
    }
}
