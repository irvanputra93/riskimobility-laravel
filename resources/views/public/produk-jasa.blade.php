{{-- resources/views/public/produk-jasa.blade.php --}}
@extends('layouts.app')
@section('title', 'Produk dan Jasa - RiskiMobility')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Katalog Armada & Layanan</h1>
    <form method="GET" action="{{ route('produk-jasa') }}" class="flex space-x-2 mt-3 md:mt-0">
        <select name="category_id" class="border rounded px-3 py-1.5 text-sm">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
            @endforeach
        </select>
        <select name="transmisi" class="border rounded px-3 py-1.5 text-sm">
            <option value="">Semua Transmisi</option>
            <option value="otomatis" {{ request('transmisi') == 'otomatis' ? 'selected' : '' }}>Otomatis</option>
            <option value="manual" {{ request('transmisi') == 'manual' ? 'selected' : '' }}>Manual</option>
        </select>
        <button type="submit" class="bg-slate-900 text-white px-4 py-1.5 rounded text-sm">Filter</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($vehicles as $v)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <img src="{{ $v->foto_url }}" alt="{{ $v->nama_kendaraan }}" class="h-48 w-full object-cover bg-slate-100">
            <div class="p-4">
                <div class="flex justify-between items-center text-xs">
                    <span class="bg-slate-100 px-2 py-0.5 rounded font-medium">{{ $v->category->nama_kategori }}</span>
                    <span class="px-2 py-0.5 rounded font-semibold {{ $v->status === 'tersedia' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ ucfirst($v->status) }}
                    </span>
                </div>
                <h3 class="font-bold text-lg mt-2">{{ $v->nama_kendaraan }}</h3>
                <p class="text-xs text-slate-500">Plat: {{ $v->plat_nomor }} • {{ ucfirst($v->transmisi) }} • {{ $v->jumlah_kursi }} Kursi</p>
                <p class="text-xs text-slate-600 mt-2">{{ $v->deskripsi }}</p>
                <div class="mt-4 pt-3 border-t flex justify-between items-center">
                    <span class="font-bold text-amber-600">Rp {{ number_format($v->tarif_harian, 0, ',', '.') }}/hari</span>
                    @if($v->status === 'tersedia')
                        <a href="{{ route('bookings.create', ['vehicle_id' => $v->id]) }}" class="bg-amber-500 text-slate-900 font-semibold text-xs px-3 py-2 rounded">Pesan</a>
                    @else
                        <span class="text-xs text-slate-400">Tidak Tersedia</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection