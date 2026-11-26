<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin RiskiMobility',
            'email' => 'admin@riskimobility.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $cust1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        Customer::create([
            'user_id' => $cust1->id,
            'no_hp' => '081234567890',
            'no_sim' => '3404123456780001',
            'alamat' => 'Jl. Kaliurang Km 8, Sleman, Yogyakarta',
        ]);

        $cust2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        Customer::create([
            'user_id' => $cust2->id,
            'no_hp' => '085712345678',
            'no_sim' => '3471987654320002',
            'alamat' => 'Jl. Kusumanegara No. 45, Umbulharjo, Yogyakarta',
        ]);
    }
}