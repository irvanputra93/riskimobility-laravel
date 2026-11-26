<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'metode'      => 'required|in:transfer,tunai,e-wallet',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pathBukti = $request->file('bukti_bayar')->store('payments', 'public');

        Payment::create([
            'booking_id'  => $booking->id,
            'metode'      => $validated['metode'],
            'jumlah'      => $booking->total_bayar,
            'status'      => 'menunggu',
            'bukti_bayar' => $pathBukti,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi Admin.');
    }

    public function verify(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:lunas,ditolak',
        ]);

        $payment->update([
            'status'        => $validated['status'],
            'verified_by'   => auth()->id() ?? 1,
            'tanggal_bayar' => $validated['status'] === 'lunas' ? now() : null,
        ]);

        return back()->with('success', 'Status pembayaran berhasil diverifikasi menjadi: ' . strtoupper($validated['status']));
    }
}