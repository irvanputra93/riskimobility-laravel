<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    protected $fillable = [
        'nama',
        'no_hp',
        'no_sim',
        'status',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }
}