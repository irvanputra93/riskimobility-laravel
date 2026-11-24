<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'verified_by',
        'metode',
        'jumlah',
        'status',
        'bukti_bayar',
        'tanggal_bayar',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'tanggal_bayar' => 'datetime',
        ];
    }

    public function getBuktiBayarUrlAttribute(): ?string
    {
        if ($this->bukti_bayar && Storage::disk('public')->exists($this->bukti_bayar)) {
            return asset('storage/' . $this->bukti_bayar);
        }
        return null;
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}