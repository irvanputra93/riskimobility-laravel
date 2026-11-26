@extends('layouts.app')
@section('title', isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <h1 class="text-xl font-bold mb-4">{{ isset($vehicle) ? 'Edit Armada: ' . $vehicle->nama_kendaraan : 'Tambah Armada Kendaraan Baru' }}</h1>

    <form action="{{ isset($vehicle) ? route('admin.vehicles.update', $vehicle->id) : route('admin.vehicles.store') }}"
          method="POST" enctype="multipart/form-data" class="space-y-4 text-sm">
        @csrf
        @if(isset($vehicle)) @method('PUT') @endif

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold mb-1">Kategori</label>
                <select name="category_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id', $vehicle->category_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Cabang Pangkalan</label>
                <select name="branch_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ old('branch_id', $vehicle->branch_id ?? '') == $b->id ? 'selected' : '' }}>{{ $b->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Nama Kendaraan</label>
                <input type="text" name="nama_kendaraan" value="{{ old('nama_kendaraan', $vehicle->nama_kendaraan ?? '') }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Merek</label>
                <input type="text" name="merek" value="{{ old('merek', $vehicle->merek ?? '') }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Plat Nomor (Unik)</label>
                <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $vehicle->plat_nomor ?? '') }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Tahun & Warna</label>
                <div class="flex space-x-2">
                    <input type="number" name="tahun" value="{{ old('tahun', $vehicle->tahun ?? 2025) }}" class="w-1/2 border rounded px-3 py-2" required>
                    <input type="text" name="warna" value="{{ old('warna', $vehicle->warna ?? 'Putih') }}" class="w-1/2 border rounded px-3 py-2" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Transmisi & Kursi</label>
                <div class="flex space-x-2">
                    <select name="transmisi" class="w-1/2 border rounded px-2 py-2">
                        <option value="otomatis" {{ old('transmisi', $vehicle->transmisi ?? '') == 'otomatis' ? 'selected' : '' }}>Otomatis</option>
                        <option value="manual" {{ old('transmisi', $vehicle->transmisi ?? '') == 'manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                    <input type="number" name="jumlah_kursi" value="{{ old('jumlah_kursi', $vehicle->jumlah_kursi ?? 7) }}" class="w-1/2 border rounded px-3 py-2" required>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Tarif Harian (Rp)</label>
                <input type="number" name="tarif_harian" value="{{ old('tarif_harian', $vehicle->tarif_harian ?? 350000) }}" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold mb-1">Status Ketersediaan</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                @foreach(['tersedia', 'disewa', 'perawatan'] as $st)
                    <option value="{{ $st }}" {{ old('status', $vehicle->status ?? 'tersedia') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold mb-1">Upload Foto Kendaraan (JPG, PNG, WEBP - Maks 2MB)</label>
            @if(isset($vehicle) && $vehicle->foto)
                <img src="{{ $vehicle->foto_url }}" class="h-24 rounded border mb-2 object-cover">
            @endif
            <input type="file" name="foto" accept="image/*" class="w-full border rounded p-2 text-xs">
        </div>

        <div>
            <label class="block text-xs font-semibold mb-1">Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="2" class="w-full border rounded px-3 py-2">{{ old('deskripsi', $vehicle->deskripsi ?? '') }}</textarea>
        </div>

        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-2.5 rounded-lg hover:bg-slate-800">
            {{ isset($vehicle) ? 'Simpan Perubahan' : 'Simpan Armada Baru' }}
        </button>
    </form>
</div>
@endsection