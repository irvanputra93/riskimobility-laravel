<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->restrictOnDelete();
            $table->string('nama_kendaraan', 100);
            $table->string('merek', 50);
            $table->string('plat_nomor', 15)->unique();
            $table->smallInteger('tahun');
            $table->string('warna', 30);
            $table->enum('transmisi', ['manual', 'otomatis']);
            $table->unsignedTinyInteger('jumlah_kursi');
            $table->decimal('tarif_harian', 12, 2);
            $table->enum('status', ['tersedia', 'disewa', 'perawatan'])->default('tersedia');
            $table->string('foto', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};