<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        $drivers = [
            ['nama' => 'Pak Hendra Wijaya', 'no_hp' => '081328112233', 'no_sim' => '890112345678', 'status' => 'tersedia'],
            ['nama' => 'Pak Agus Riyanto', 'no_hp' => '081328445566', 'no_sim' => '890187654321', 'status' => 'bertugas'],
            ['nama' => 'Pak Slamet Raharjo', 'no_hp' => '081328778899', 'no_sim' => '890155667788', 'status' => 'tersedia'],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }
    }
}