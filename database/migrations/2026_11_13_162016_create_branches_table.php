<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('nama_cabang', 100);
            $table->string('kota', 80);
            $table->enum('wilayah', ['Sumatera', 'Jawa & Bali', 'Kalimantan', 'Sulawesi', 'Lainnya']);
            $table->text('alamat');
            $table->string('telepon', 20);
            $table->string('email', 150);
            $table->string('no_whatsapp', 20);
            $table->boolean('is_pusat')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};