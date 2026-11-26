@extends('layouts.admin')
@section('title', 'Detail Armada - ' . $vehicle->nama_kendaraan)

@section('content')
<!-- buat detail mobil -->
<div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <div class="flex justify-between items-center border-b border-slate-200 pb-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-900">{{ $vehicle->nama_kendaraan }} ({{ $vehicle->plat_nomor }})</h1>
            <p class="text-xs text-slate-500 mt-0.5">Informasi spesifikasi, riwayat penyewaan, dan catatan perawatan unit</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="bg-amber-500 text-slate-900 px-4 py-2 rounded-lg text-xs font-bold hover:bg-amber-400">
                <i class="fa-solid fa-pen-to-square mr-1"></i>Edit Unit
            </a>
            <a href="{{ route('admin.vehicles.index') }}" class="border border-slate-300 px-4 py-2 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50">
                &larr; Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <img src="{{ $vehicle->foto_url }}" alt="{{ $vehicle->nama_kendaraan }}" class="w-full h-64 object-cover rounded-xl border bg-slate-100">
        </div>
        <div class="space-y-2.5 text-sm">
            <p><strong>Merek / Tahun:</strong> {{ $vehicle->merek }} ({{ $vehicle->tahun }})</p>
            <p><strong>Kategori:</strong> {{ $vehicle->category->nama_kategori }}</p>
            <p><strong>Cabang Pangkalan:</strong> {{ $vehicle->branch->nama_cabang }} ({{ $vehicle->branch->kota }})</p>
            <p><strong>Transmisi & Kursi:</strong> {{ ucfirst($vehicle->transmisi) }} • {{ $vehicle->jumlah_kursi }} Kursi</p>
            <p><strong>Warna:</strong> {{ $vehicle->warna }}</p>
            <p><strong>Tarif Sewa Harian:</strong> <span class="text-amber-600 font-bold">Rp {{ number_format($vehicle->tarif_harian, 0, ',', '.') }} / hari</span></p>
            <p><strong>Status Saat Ini:</strong> <span class="uppercase font-bold">{{ $vehicle->status }}</span></p>
            <p class="pt-2 text-slate-600"><strong>Deskripsi:</strong><br>{{ $vehicle->deskripsi ?? '-' }}</p>
        </div>
    </div>
</div>
@endsection