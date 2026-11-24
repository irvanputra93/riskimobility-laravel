@extends('layouts.app')
@section('title', 'Form Penyewaan Kendaraan - RiskiMobility')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <h1 class="text-xl font-bold mb-4">Form Penyewaan Kendaraan</h1>

    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold mb-1">Pilih Armada Kendaraan</label>
                <select name="vehicle_id" class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}" {{ (old('vehicle_id', optional($selectedVehicle)->id) == $v->id) ? 'selected' : '' }}>
                            {{ $v->nama_kendaraan }} ({{ $v->plat_nomor }}) - Rp {{ number_format($v->tarif_harian, 0, ',', '.') }}/hari
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Jenis Layanan (Opsi Sopir)</label>
                <select name="service_type_id" class="w-full border rounded px-3 py-2 text-sm" required>
                    @foreach($serviceTypes as $st)
                        <option value="{{ $st->id }}" {{ old('service_type_id') == $st->id ? 'selected' : '' }}>
                            {{ $st->nama_layanan }} {{ $st->dengan_sopir ? '(+Sopir Rp ' . number_format($st->biaya_tambahan_harian, 0, ',', '.') . '/hari)' : '(Lepas Kunci)' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Lokasi Cabang Pengambilan</label>
                <select name="pickup_branch_id" class="w-full border rounded px-3 py-2 text-sm" required>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ old('pickup_branch_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_cabang }} ({{ $b->kota }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Penyewa</label>
                <input type="text" value="{{ auth()->user()->name }} (SIM: {{ optional(auth()->user()->customer)->no_sim }})" class="w-full border bg-slate-100 rounded px-3 py-2 text-sm" readonly>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Tanggal Ambil</label>
                <input type="date" name="tanggal_ambil" value="{{ old('tanggal_ambil', date('Y-m-d')) }}" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Jam Ambil</label>
                <input type="time" name="jam_ambil" value="{{ old('jam_ambil', '08:00') }}" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Tanggal Kembali (Inklusif Dihitung)</label>
                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+2 days'))) }}" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="block text-xs font-semibold mb-1">Jam Kembali</label>
                <input type="time" name="jam_kembali" value="{{ old('jam_kembali', '20:00') }}" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold mb-1">Catatan Tambahan (Opsional)</label>
            <textarea name="catatan" rows="2" class="w-full border rounded px-3 py-2 text-sm" placeholder="Contoh: Jemput di stasiun / bandara...">{{ old('catatan') }}</textarea>
        </div>

        <button type="submit" class="w-full bg-amber-500 text-slate-900 font-bold py-2.5 rounded-lg hover:bg-amber-400">
            Konfirmasi Pemesanan
        </button>
    </form>
</div>
@endsection