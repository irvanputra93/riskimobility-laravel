<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'dengan_sopir',
        'biaya_tambahan_harian',
    ];

    protected function casts(): array
    {
        return [
            'dengan_sopir' => 'boolean',
            'biaya_tambahan_harian' => 'decimal:2',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'service_type_id');
    }
}