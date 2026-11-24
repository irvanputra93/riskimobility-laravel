<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BranchSeeder::class,
            ServiceTypeSeeder::class,
            DriverSeeder::class,
            VehicleSeeder::class,
            BookingSeeder::class,
            PaymentSeeder::class,
            MaintenanceSeeder::class,
        ]);
    }
}