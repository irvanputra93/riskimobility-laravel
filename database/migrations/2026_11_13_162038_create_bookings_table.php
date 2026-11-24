<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking', 20)->unique();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles')->restrictOnDelete();
            $table->foreignId('service_type_id')->constrained('service_types')->restrictOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
            $table->foreignId('pickup_branch_id')->constrained('branches')->restrictOnDelete();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal_ambil');
            $table->time('jam_ambil');
            $table->date('tanggal_kembali');
            $table->time('jam_kembali');
            $table->unsignedSmallInteger('durasi_hari');
            $table->decimal('tarif_harian', 12, 2);
            $table->decimal('biaya_sopir', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2);
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'berjalan', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};