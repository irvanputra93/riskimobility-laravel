<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'kode_booking',
        'customer_id',
        'vehicle_id',
        'service_type_id',
        'driver_id',
        'pickup_branch_id',
        'handled_by',
        'tanggal_ambil',
        'jam_ambil',
        'tanggal_kembali',
        'jam_kembali',
        'durasi_hari',
        'tarif_harian',
        'biaya_sopir',
        'total_bayar',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_ambil' => 'date',
            'tanggal_kembali' => 'date',
            'durasi_hari' => 'integer',
            'tarif_harian' => 'decimal:2',
            'biaya_sopir' => 'decimal:2',
            'total_bayar' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function pickupBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'pickup_branch_id');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }
}