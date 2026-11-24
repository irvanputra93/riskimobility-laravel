<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->restrictOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('metode', ['transfer', 'tunai', 'e-wallet']);
            $table->decimal('jumlah', 12, 2);
            $table->enum('status', ['menunggu', 'lunas', 'ditolak'])->default('menunggu');
            $table->string('bukti_bayar', 255)->nullable();
            $table->dateTime('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};