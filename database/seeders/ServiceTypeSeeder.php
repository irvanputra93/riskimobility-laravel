<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'nama_layanan' => 'Daily Car Rental',
                'deskripsi' => 'Mobil harian lepas kunci untuk kebutuhan pribadi, keluarga, maupun aktivitas sehari-hari.',
                'dengan_sopir' => false,
                'biaya_tambahan_harian' => 0,
            ],
            [
                'nama_layanan' => 'Family & Business Rental',
                'deskripsi' => 'Kendaraan untuk perjalanan keluarga, keperluan kerja, dan kegiatan bisnis.',
                'dengan_sopir' => false,
                'biaya_tambahan_harian' => 0,
            ],
            [
                'nama_layanan' => 'Rental with Driver',
                'deskripsi' => 'Kendaraan lengkap dengan pengemudi profesional supaya perjalanan lebih praktis.',
                'dengan_sopir' => true,
                'biaya_tambahan_harian' => 250000,
            ],
            [
                'nama_layanan' => 'Travel & Tourism',
                'deskripsi' => 'Kendaraan untuk wisata, liburan, dan perjalanan luar kota bersama pengemudi berpengalaman.',
                'dengan_sopir' => true,
                'biaya_tambahan_harian' => 250000,
            ],
        ];

        foreach ($services as $service) {
            ServiceType::create($service);
        }
    }
}