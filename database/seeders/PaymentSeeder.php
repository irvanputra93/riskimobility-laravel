<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::create([
            'booking_id' => 1,
            'verified_by' => 1,
            'metode' => 'transfer',
            'jumlah' => 1800000,
            'status' => 'lunas',
            'bukti_bayar' => 'payments/bukti-rm0041.jpg',
            'tanggal_bayar' => '2026-11-11 14:30:00',
        ]);

        Payment::create([
            'booking_id' => 2,
            'verified_by' => 1,
            'metode' => 'e-wallet',
            'jumlah' => 1300000,
            'status' => 'lunas',
            'bukti_bayar' => 'payments/bukti-rm0042.jpg',
            'tanggal_bayar' => '2026-11-12 19:15:00',
        ]);
    }
}