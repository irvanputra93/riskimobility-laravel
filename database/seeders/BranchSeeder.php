<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'nama_cabang' => 'RiskiMobility Kantor Pusat Yogyakarta',
                'kota' => 'Yogyakarta',
                'wilayah' => 'Jawa & Bali',
                'alamat' => 'Jl. Janti Karang Jambe No. 143, Banguntapan, Yogyakarta',
                'telepon' => '0274-456789',
                'email' => 'pusat.jogja@riskimobility.com',
                'no_whatsapp' => '62811250001',
                'is_pusat' => true,
            ],
            [
                'nama_cabang' => 'RiskiMobility Cabang Jakarta Selatan',
                'kota' => 'Jakarta',
                'wilayah' => 'Jawa & Bali',
                'alamat' => 'Jl. TB Simatupang Kav. 18, Cilandak, Jakarta Selatan',
                'telepon' => '021-7890123',
                'email' => 'jakarta@riskimobility.com',
                'no_whatsapp' => '62811250002',
                'is_pusat' => false,
            ],
            [
                'nama_cabang' => 'RiskiMobility Cabang Bandung',
                'kota' => 'Bandung',
                'wilayah' => 'Jawa & Bali',
                'alamat' => 'Jl. Soekarno Hatta No. 512, Kota Bandung',
                'telepon' => '022-6543210',
                'email' => 'bandung@riskimobility.com',
                'no_whatsapp' => '62811250003',
                'is_pusat' => false,
            ],
            [
                'nama_cabang' => 'RiskiMobility Cabang Surabaya',
                'kota' => 'Surabaya',
                'wilayah' => 'Jawa & Bali',
                'alamat' => 'Jl. Ahmad Yani No. 88, Wonocolo, Surabaya',
                'telepon' => '031-8765432',
                'email' => 'surabaya@riskimobility.com',
                'no_whatsapp' => '62811250004',
                'is_pusat' => false,
            ],
            [
                'nama_cabang' => 'RiskiMobility Cabang Denpasar',
                'kota' => 'Denpasar',
                'wilayah' => 'Jawa & Bali',
                'alamat' => 'Jl. Bypass Ngurah Rai No. 102, Sanur, Denpasar',
                'telepon' => '0361-234567',
                'email' => 'bali@riskimobility.com',
                'no_whatsapp' => '62811250005',
                'is_pusat' => false,
            ],
            [
                'nama_cabang' => 'RiskiMobility Cabang Balikpapan',
                'kota' => 'Balikpapan',
                'wilayah' => 'Kalimantan',
                'alamat' => 'Jl. Jenderal Sudirman No. 25, Balikpapan Selatan',
                'telepon' => '0542-765432',
                'email' => 'balikpapan@riskimobility.com',
                'no_whatsapp' => '62811250006',
                'is_pusat' => false,
            ],
            [
                'nama_cabang' => 'RiskiMobility Cabang Makassar',
                'kota' => 'Makassar',
                'wilayah' => 'Sulawesi',
                'alamat' => 'Jl. AP Pettarani No. 77, Panakkukang, Makassar',
                'telepon' => '0411-456123',
                'email' => 'makassar@riskimobility.com',
                'no_whatsapp' => '62811250007',
                'is_pusat' => false,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}