<?php

namespace Database\Seeders;

use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run(): void
    {
        Maintenance::create([
            'vehicle_id' => 5, 
            'jenis_perawatan' => 'Servis Rutin Berkala & Ganti Oli Mesin',
            'tanggal_mulai' => '2026-11-12',
            'tanggal_selesai' => null,
            'biaya' => 850000,
            'keterangan' => 'Pengecekan kampas rem dan penggantian oli 10.000 KM di bengkel resmi.',
            'status' => 'proses',
        ]);
    }
}