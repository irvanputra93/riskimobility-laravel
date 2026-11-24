<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Driver;
use App\Models\ServiceType;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $query = Booking::with(['vehicle', 'serviceType', 'pickupBranch', 'driver', 'payments'])->latest();

        if (auth()->user()->role === 'customer') {
            $query->where('customer_id', auth()->user()->customer->id);
        }

        $bookings = $query->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $vehicles = Vehicle::where('status', 'tersedia')->get();
        $selectedVehicle = $request->filled('vehicle_id') ? Vehicle::find($request->vehicle_id) : null;
        $branches = Branch::all();
        $serviceTypes = ServiceType::all();

        return view('bookings.create', compact('vehicles', 'selectedVehicle', 'branches', 'serviceTypes'));
    }

    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();
        $customerId = auth()->user()->customer->id;

        $isBooked = Booking::where('vehicle_id', $validated['vehicle_id'])
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'berjalan'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('tanggal_ambil', [$validated['tanggal_ambil'], $validated['tanggal_kembali']])
                  ->orWhereBetween('tanggal_kembali', [$validated['tanggal_ambil'], $validated['tanggal_kembali']])
                  ->orWhere(function ($sub) use ($validated) {
                      $sub->where('tanggal_ambil', '<=', $validated['tanggal_ambil'])
                          ->where('tanggal_kembali', '>=', $validated['tanggal_kembali']);
                  });
            })
            ->exists();

        if ($isBooked) {
            return back()->withInput()->with('error', 'Kendaraan sudah dipesan pada rentang tanggal tersebut. Silakan pilih tanggal atau unit lain.');
        }

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        $serviceType = ServiceType::findOrFail($validated['service_type_id']);

        $durasiHari = Carbon::parse($validated['tanggal_ambil'])->diffInDays(Carbon::parse($validated['tanggal_kembali'])) + 1;
        $tarifHarian = $vehicle->tarif_harian;
        $biayaSopir = $serviceType->dengan_sopir ? ($serviceType->biaya_tambahan_harian * $durasiHari) : 0;
        $totalBayar = ($tarifHarian * $durasiHari) + $biayaSopir;

        $nextId = (Booking::max('id') ?? 40) + 1;
        $kodeBooking = 'RM-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Booking::create([
            'kode_booking'     => $kodeBooking,
            'customer_id'      => $customerId,
            'vehicle_id'       => $vehicle->id,
            'service_type_id'  => $serviceType->id,
            'pickup_branch_id' => $validated['pickup_branch_id'],
            'tanggal_ambil'    => $validated['tanggal_ambil'],
            'jam_ambil'        => $validated['jam_ambil'],
            'tanggal_kembali'  => $validated['tanggal_kembali'],
            'jam_kembali'      => $validated['jam_kembali'],
            'durasi_hari'      => $durasiHari,
            'tarif_harian'     => $tarifHarian,
            'biaya_sopir'      => $biayaSopir,
            'total_bayar'      => $totalBayar,
            'status'           => 'menunggu',
            'catatan'          => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', "Pesanan $kodeBooking berhasil dibuat ($durasiHari hari). Total: Rp " . number_format($totalBayar, 0, ',', '.'));
    }

    public function cancel(Booking $booking)
    {
        if (auth()->user()->role === 'customer' && $booking->customer_id !== auth()->user()->customer->id) {
            abort(403);
        }

        if (!in_array($booking->status, ['menunggu', 'dikonfirmasi'])) {
            return back()->with('error', 'Pesanan yang sedang berjalan atau sudah selesai tidak dapat dibatalkan.');
        }

        $booking->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Pesanan ' . $booking->kode_booking . ' telah dibatalkan dan jadwal unit kembali terbuka.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status'    => 'required|in:dikonfirmasi,berjalan,selesai,dibatalkan',
            'driver_id' => 'nullable|exists:drivers,id',
        ]);

        if ($validated['status'] === 'dikonfirmasi' && $booking->serviceType->dengan_sopir && !$booking->driver_id) {
            $availableDriver = Driver::where('status', 'tersedia')->first();
            $booking->driver_id = $validated['driver_id'] ?? optional($availableDriver)->id;
        }

        $booking->status = $validated['status'];
        $booking->handled_by = auth()->id();
        $booking->save();

        if ($validated['status'] === 'berjalan') {
            $booking->vehicle->update(['status' => 'disewa']);
            if ($booking->driver) {
                $booking->driver->update(['status' => 'bertugas']);
            }
        } elseif (in_array($validated['status'], ['selesai', 'dibatalkan'])) {
            $booking->vehicle->update(['status' => 'tersedia']);
            if ($booking->driver) {
                $booking->driver->update(['status' => 'tersedia']);
            }
        }

        return back()->with('success', "Status pesanan {$booking->kode_booking} berhasil diubah menjadi {$booking->status}.");
    }
}