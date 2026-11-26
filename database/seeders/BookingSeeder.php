<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        Booking::create([
            'kode_booking' => 'RM-0041',
            'customer_id' => 1,
            'vehicle_id' => 1,      
            'service_type_id' => 3, 
            'driver_id' => 1,       
            'pickup_branch_id' => 1,
            'handled_by' => 1,      
            'tanggal_ambil' => '2026-11-12',
            'jam_ambil' => '08:00:00',
            'tanggal_kembali' => '2026-11-14',
            'jam_kembali' => '20:00:00',
            'durasi_hari' => 3,
            'tarif_harian' => 350000,
            'biaya_sopir' => 750000, 
            'total_bayar' => 1800000,
            'status' => 'selesai',
            'catatan' => 'Penjemputan tepat waktu di kantor pusat Yogyakarta.',
        ]);

        Booking::create([
            'kode_booking' => 'RM-0042',
            'customer_id' => 2,
            'vehicle_id' => 2,      
            'service_type_id' => 1, 
            'driver_id' => null,
            'pickup_branch_id' => 1,
            'handled_by' => 1,
            'tanggal_ambil' => '2026-11-13',
            'jam_ambil' => '09:00:00',
            'tanggal_kembali' => '2026-11-14',
            'jam_kembali' => '09:00:00',
            'durasi_hari' => 2,
            'tarif_harian' => 650000,
            'biaya_sopir' => 0,
            'total_bayar' => 1300000,
            'status' => 'berjalan',
            'catatan' => 'Sewa lepas kunci untuk keperluan dinas.',
        ]);
    }
}