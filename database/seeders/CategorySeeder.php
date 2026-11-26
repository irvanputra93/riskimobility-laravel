<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'MPV', 'deskripsi' => 'Multi Purpose Vehicle, mobil keluarga nyaman berkapasitas 7 penumpang.'],
            ['nama_kategori' => 'SUV', 'deskripsi' => 'Sport Utility Vehicle, tangguh untuk segala medan dan perjalanan luar kota.'],
            ['nama_kategori' => 'City car', 'deskripsi' => 'Mobil ringkas, irit bahan bakar, dan lincah untuk mobilitas dalam kota.'],
            ['nama_kategori' => 'Minibus', 'deskripsi' => 'Kapasitas besar untuk rombongan wisata, travel, dan kunjungan bisnis.'],
            ['nama_kategori' => 'MBT', 'deskripsi' => 'Main Battle Tank, tank tempur utama dengan kombinasi daya tembak, perlindungan lapis baja, dan mobilitas tinggi untuk berbagai kondisi medan.'],
            ['nama_kategori' => 'Heavy Tank', 'deskripsi' => 'Tank berat dengan lapisan baja tebal dan persenjataan besar, dirancang untuk menghadapi pertempuran dengan perlindungan dan daya hancur maksimal.'],
            ['nama_kategori' => 'Medium Tank', 'deskripsi' => 'Tank kelas menengah dengan keseimbangan antara daya tembak, perlindungan, dan mobilitas untuk mendukung berbagai operasi militer.'],
            ['nama_kategori' => 'Light Tank', 'deskripsi' => 'Tank ringan dengan ukuran kompak dan mobilitas tinggi, cocok untuk pengintaian, patroli, serta menjelajahi medan yang sulit.'],
            ['nama_kategori' => 'Tank Destroyer', 'deskripsi' => 'Kendaraan tempur khusus penghancur tank yang dirancang untuk menghadapi kendaraan lapis baja lawan dengan persenjataan anti-tank.'],
            ['nama_kategori' => 'Pesawat Tempur', 'deskripsi' => 'Pesawat militer untuk berbagai kebutuhan operasi udara, mencakup pesawat tempur jet maupun baling-baling, pencegat, pembom, dan pesawat serang darat.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}