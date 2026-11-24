@extends('layouts.app')
@section('title', 'Riwayat Penyewaan Saya - RiskiMobility')

@section('content')
<h1 class="text-2xl font-bold mb-4">Riwayat Penyewaan & Pembayaran</h1>

<div class="space-y-4">
    @forelse($bookings as $b)
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex flex-col md:flex-row justify-between gap-4">
            <div class="space-y-1 text-sm">
                <div class="flex items-center space-x-2">
                    <span class="font-mono font-bold text-slate-900 bg-amber-100 px-2 py-0.5 rounded">{{ $b->kode_booking }}</span>
                    <span class="text-xs px-2 py-0.5 rounded font-semibold uppercase bg-slate-100">{{ $b->status }}</span>
                </div>
                <p class="font-bold text-base mt-1">{{ $b->vehicle->nama_kendaraan }} ({{ $b->vehicle->plat_nomor }})</p>
                <p class="text-xs text-slate-600">Layanan: {{ $b->serviceType->nama_layanan }} | Cabang Ambil: {{ $b->pickupBranch->kota }}</p>
                <p class="text-xs text-slate-600">Jadwal: {{ $b->tanggal_ambil->format('d M Y') }} ({{ $b->jam_ambil }}) s/d {{ $b->tanggal_kembali->format('d M Y') }} ({{ $b->jam_kembali }}) — <strong>{{ $b->durasi_hari }} Hari</strong></p>
                @if($b->driver)
                    <p class="text-xs text-emerald-700 font-medium">Sopir Pendamping: {{ $b->driver->nama }} ({{ $b->driver->no_hp }})</p>
                @endif
                <p class="font-bold text-amber-600 pt-1">Total Biaya: Rp {{ number_format($b->total_bayar, 0, ',', '.') }}</p>
            </div>

            <div class="border-t md:border-t-0 md:border-l pt-3 md:pt-0 md:pl-4 flex flex-col justify-center min-w-[280px]">
                @php $latestPayment = $b->payments->last(); @endphp

                @if($latestPayment && $latestPayment->status === 'lunas')
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-2 rounded text-center">PEMBAYARAN LUNAS</span>
                @elseif(in_array($b->status, ['menunggu', 'dikonfirmasi']))
                    <form action="{{ route('payments.store', $b->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                        @csrf
                        <label class="block text-xs font-semibold">Upload Bukti Pembayaran (JPG/PNG):</label>
                        <select name="metode" class="w-full border rounded px-2 py-1 text-xs" required>
                            <option value="transfer">Transfer Bank</option>
                            <option value="e-wallet">E-Wallet (QRIS/OVO/GoPay)</option>
                            <option value="tunai">Tunai di Cabang</option>
                        </select>
                        <input type="file" name="bukti_bayar" accept="image/*" class="w-full text-xs border rounded p-1" required>
                        <button type="submit" class="w-full bg-slate-900 text-white text-xs py-1.5 rounded hover:bg-slate-700">
                            Unggah Bukti Bayar
                        </button>
                    </form>

                    <form action="{{ route('bookings.cancel', $b->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full border border-red-500 text-red-600 text-xs py-1 rounded hover:bg-red-50">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-sm text-slate-500">Belum ada riwayat penyewaan kendaraan.</p>
    @endforelse
</div>
@endsection