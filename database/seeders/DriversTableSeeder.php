<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\DriverDocument;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DriversTableSeeder extends Seeder
{
    public function run(): void
    {
        $czechNames = [
            ['first' => 'Jan', 'last' => 'Novák'],
            ['first' => 'Petr', 'last' => 'Svoboda'],
            ['first' => 'Josef', 'last' => 'Novotný'],
            ['first' => 'Pavel', 'last' => 'Dvořák'],
            ['first' => 'Martin', 'last' => 'Černý'],
            ['first' => 'Tomáš', 'last' => 'Procházka'],
            ['first' => 'Jaroslav', 'last' => 'Kučera'],
            ['first' => 'Miroslav', 'last' => 'Veselý'],
            ['first' => 'Zdeněk', 'last' => 'Horák'],
            ['first' => 'Jiří', 'last' => 'Němec'],
            ['first' => 'Václav', 'last' => 'Pokorný'],
            ['first' => 'František', 'last' => 'Pospíšil'],
            ['first' => 'Karel', 'last' => 'Král'],
            ['first' => 'Lukáš', 'last' => 'Bartoš'],
            ['first' => 'Milan', 'last' => 'Jelínek'],
            ['first' => 'Stanislav', 'last' => 'Růžička'],
            ['first' => 'Vladimír', 'last' => 'Beneš'],
            ['first' => 'David', 'last' => 'Fiala'],
            ['first' => 'Michal', 'last' => 'Sedláček'],
            ['first' => 'Jakub', 'last' => 'Marek'],
            ['first' => 'Radek', 'last' => 'Doležal'],
            ['first' => 'Filip', 'last' => 'Soukup'],
            ['first' => 'Ondřej', 'last' => 'Blažek'],
            ['first' => 'Adam', 'last' => 'Krejčí'],
            ['first' => 'Marek', 'last' => 'Urban'],
        ];

        foreach ($czechNames as $name) {
            $driver = Driver::create([
                'first_name' => $name['first'],
                'last_name' => $name['last'],
                'birth_date' => Carbon::now()->subYears(rand(25, 60))->subDays(rand(1, 365)),
                'citizenship' => 'CZ',
                'email' => strtolower($name['first'] . '.' . $name['last'] . '@demo.g-track.eu'),
                'phone' => '+420' . rand(600000000, 799999999),
                'reg_address' => 'Testovací ulice ' . rand(1, 50) . ', Praha 1, 11000',
                'res_address' => rand(0, 1) ? 'Pobytová ulice ' . rand(1, 50) . ', Praha 3, 13000' : null,
                'status' => $this->randomStatus(),
                'hire_date' => Carbon::now()->subYears(rand(1, 10)),
                'contract_from' => Carbon::now()->subMonths(rand(1, 24)),
                'contract_to' => rand(0, 1) ? Carbon::now()->addMonths(rand(6, 24)) : null,
                'contract_indefinite' => (bool) rand(0, 1),
                'work_location' => rand(0, 1) ? 'praha' : 'kladno',
                'bank_country' => 'CZ',
                'bank_account' => rand(1000000000, 9999999999) . '/0800',
                'iban' => 'CZ' . rand(10, 99) . rand(1000000000000000, 9999999999999999),
                'swift' => 'GIBACZPX',
                'flags' => [
                    'pas_souhlas' => (bool) rand(0, 1),
                    'propiska_cz' => (bool) rand(0, 1),
                ],
            ]);

            $this->createDocuments($driver);
        }
    }

    private function randomStatus(): string
    {
        $statuses = ['active', 'active', 'active', 'active', 'on_leave', 'inactive'];

        return $statuses[array_rand($statuses)];
    }

    private function createDocuments(Driver $driver): void
    {
        $documentTypes = [
            'passport' => ['has_number' => true, 'has_expiry' => true],
            'visa' => ['has_number' => true, 'has_expiry' => true],
            'residence' => ['has_number' => false, 'has_expiry' => true],
            'drivers_licence' => ['has_number' => true, 'has_expiry' => true],
            'chip' => ['has_number' => true, 'has_expiry' => true],
            'kod_95' => ['has_number' => false, 'has_expiry' => true],
            'prohlidka' => ['has_number' => false, 'has_expiry' => true],
            'a1_eu' => ['has_number' => false, 'has_expiry' => true],
            'pojisteni' => ['has_number' => false, 'has_expiry' => true],
        ];

        foreach ($documentTypes as $type => $config) {
            $statusType = rand(1, 10);

            if ($statusType <= 5) {
                $expiryDate = Carbon::now()->addMonths(rand(3, 24));
            } elseif ($statusType <= 7) {
                $expiryDate = Carbon::now()->addDays(rand(1, 30));
            } elseif ($statusType <= 9) {
                $expiryDate = Carbon::now()->subDays(rand(1, 180));
            } else {
                $expiryDate = null;
            }

            DriverDocument::create([
                'driver_id' => $driver->id,
                'type' => $type,
                'number' => $config['has_number'] ? strtoupper(substr($type, 0, 2)) . rand(100000, 999999) : null,
                'country' => in_array($type, ['passport', 'visa', 'drivers_licence']) ? 'CZ' : null,
                'from' => $expiryDate ? Carbon::now()->subYears(rand(1, 3)) : null,
                'to' => $expiryDate,
            ]);
        }
    }
}
