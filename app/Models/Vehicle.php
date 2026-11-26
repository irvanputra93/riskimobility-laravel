<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Vehicle extends Model
{
    protected $fillable = [
        'category_id',
        'branch_id',
        'nama_kendaraan',
        'merek',
        'plat_nomor',
        'tahun',
        'warna',
        'transmisi',
        'jumlah_kursi',
        'tarif_harian',
        'status',
        'foto',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'jumlah_kursi' => 'integer',
            'tarif_harian' => 'decimal:2',
        ];
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-car.png');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'vehicle_id');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class, 'vehicle_id');
    }
}