<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'category_id' => 1, 
                'branch_id' => 1,   
                'nama_kendaraan' => 'Toyota Avanza',
                'merek' => 'Toyota',
                'plat_nomor' => 'AB 1234 XY',
                'tahun' => 2024,
                'warna' => 'Putih',
                'transmisi' => 'otomatis',
                'jumlah_kursi' => 7,
                'tarif_harian' => 350000,
                'status' => 'tersedia',
                'foto' => 'vehicles/avanza.jpg',
                'deskripsi' => 'MPV irit dan nyaman untuk perjalanan keluarga di dalam maupun luar kota.',
            ],
            [
                'category_id' => 1, 
                'branch_id' => 1,
                'nama_kendaraan' => 'Toyota Innova Zenix',
                'merek' => 'Toyota',
                'plat_nomor' => 'AB 8899 ZZ',
                'tahun' => 2025,
                'warna' => 'Hitam Metalik',
                'transmisi' => 'otomatis',
                'jumlah_kursi' => 7,
                'tarif_harian' => 650000,
                'status' => 'disewa',
                'foto' => 'vehicles/innova-zenix.jpg',
                'deskripsi' => 'MPV premium dengan kabin ekstra lega dan fitur keselamatan modern.',
            ],
            [
                'category_id' => 3, 
                'branch_id' => 1,
                'nama_kendaraan' => 'Honda Brio RS',
                'merek' => 'Honda',
                'plat_nomor' => 'AB 4321 KA',
                'tahun' => 2024,
                'warna' => 'Kuning',
                'transmisi' => 'otomatis',
                'jumlah_kursi' => 5,
                'tarif_harian' => 300000,
                'status' => 'tersedia',
                'foto' => 'vehicles/brio.jpg',
                'deskripsi' => 'City car gesit, hemat BBM, cocok untuk mobilitas harian.',
            ],
            [
                'category_id' => 2, 
                'branch_id' => 2,   
                'nama_kendaraan' => 'Toyota Fortuner VRZ',
                'merek' => 'Toyota',
                'plat_nomor' => 'B 1080 RFD',
                'tahun' => 2024,
                'warna' => 'Hitam',
                'transmisi' => 'otomatis',
                'jumlah_kursi' => 7,
                'tarif_harian' => 1200000,
                'status' => 'tersedia',
                'foto' => 'vehicles/fortuner.jpg',
                'deskripsi' => 'SUV gagah nan tangguh untuk perjalanan bisnis eksekutif maupun medan berat.',
            ],
            [
                'category_id' => 1, 
                'branch_id' => 3,   
                'nama_kendaraan' => 'Mitsubishi Xpander Ultimate',
                'merek' => 'Mitsubishi',
                'plat_nomor' => 'D 1551 VSC',
                'tahun' => 2024,
                'warna' => 'Silver',
                'transmisi' => 'otomatis',
                'jumlah_kursi' => 7,
                'tarif_harian' => 400000,
                'status' => 'perawatan',
                'foto' => 'vehicles/xpander.jpg',
                'deskripsi' => 'Suspensi empuk dan kabin senyap, favorit keluarga Indonesia.',
            ],
            [
                'category_id' => 4, 
                'branch_id' => 1,   
                'nama_kendaraan' => 'Toyota Hiace Premio',
                'merek' => 'Toyota',
                'plat_nomor' => 'AB 7700 TR',
                'tahun' => 2024,
                'warna' => 'Putih',
                'transmisi' => 'manual',
                'jumlah_kursi' => 14,
                'tarif_harian' => 1100000,
                'status' => 'tersedia',
                'foto' => 'vehicles/hiace.jpg',
                'deskripsi' => 'Minibus pariwisata kapasitas 14 kursi untuk rombongan liburan dan instansi.',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}