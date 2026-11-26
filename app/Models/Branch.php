<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = [
        'nama_cabang',
        'kota',
        'wilayah',
        'alamat',
        'telepon',
        'email',
        'no_whatsapp',
        'is_pusat',
    ];

    protected function casts(): array
    {
        return [
            'is_pusat' => 'boolean',
        ];
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'branch_id');
    }

    public function pickupBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'pickup_branch_id');
    }
}