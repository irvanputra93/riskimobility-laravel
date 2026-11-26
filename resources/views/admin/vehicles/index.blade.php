@extends('layouts.admin')
@section('title', 'Data Kendaraan - RiskiMobility')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Data Kendaraan</h1>
    <p class="text-xs text-slate-500 mt-1">Pantau armada, diagram sebaran unit, dan kelola data kendaraan RiskiMobility.</p>
</div>

<!-- 4 kartu ringkasan atas sesuai mockup figma tapi pakai tone warna slate & amber -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-center">
            <p class="text-xs text-slate-500">Total kendaraan</p>
            <i class="fa-solid fa-car-On text-slate-400"></i>
        </div>
        <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $totalArmada }}</p>
        <p class="text-xs text-slate-500 mt-1">+{{ $categories->count() }} kategori terdaftar</p>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-center">
            <p class="text-xs text-slate-500">Sedang disewa</p>
            <i class="fa-solid fa-road text-amber-500"></i>
        </div>
        <p class="text-2xl font-extrabold text-amber-600 mt-2">{{ $armadaDisewa }}</p>
        <p class="text-xs text-slate-500 mt-1">
            {{ $totalArmada > 0 ? round(($armadaDisewa / $totalArmada) * 100) : 0 }}% dari armada
        </p>
    </div>

    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-center">
            <p class="text-xs text-slate-500">Pesanan hari ini</p>
            <i class="fa-solid fa-calendar-day text-sky-500"></i>
        </div>
        <p class="text-2xl font-extrabold text-slate-900 mt-2">{{ $pesananHariIni }}</p>
        <p class="text-xs text-slate-500 mt-1">{{ $menungguKonfirmasi }} menunggu konfirmasi</p>
    </div>

    <div class="bg-slate-900 text-white p-5 rounded-xl shadow-sm">
        <div class="flex justify-between items-center">
            <p class="text-xs text-slate-400">Pendapatan bulan ini</p>
            <i class="fa-solid fa-wallet text-amber-400"></i>
        </div>
        <p class="text-2xl font-extrabold text-amber-400 mt-2">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </p>
        <p class="text-xs text-slate-400 mt-1">+12% pertumbuhan transaksi</p>
    </div>
</div>

<!-- baris diagram pertama: grafik pendapatan 7 bulan sama status ketersediaan armada -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">

    <!-- grafik batang pendapatan 7 bulan terakhir -->
    <div class="lg:col-span-8 bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <h2 class="font-bold text-sm text-slate-900 mb-4">
            <i class="fa-solid fa-chart-bar text-amber-500 mr-1.5"></i>Pendapatan 7 bulan terakhir (juta rupiah)
        </h2>

        <div class="h-48 flex items-end justify-between gap-4 pt-6 px-4 border-b border-slate-100 pb-2">
            @foreach($revenueChart as $bar)
                <div class="flex-1 flex flex-col items-center group">
                    <span class="text-[11px] font-semibold text-slate-500 mb-1 opacity-85 group-hover:opacity-100 transition">
                        {{ $bar['juta'] }} jt
                    </span>
                    <div class="w-full max-w-[52px] rounded-t-lg transition-all duration-300 {{ $bar['is_current'] ? 'bg-amber-500' : 'bg-slate-300 group-hover:bg-slate-400' }}"
                         style="height: {{ $bar['height_pct'] * 1.4 }}px;">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between gap-4 px-4 pt-3 text-xs text-slate-500">
            @foreach($revenueChart as $bar)
                <div class="flex-1 text-center {{ $bar['is_current'] ? 'font-bold text-slate-900' : '' }}">{{ $bar['label'] }}</div>
            @endforeach
        </div>
    </div>

    <!-- diagram status armada buat ngecek perbandingan yang tersedia, disewa, atau perawatan -->
    <div class="lg:col-span-4 bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <h2 class="font-bold text-sm text-slate-900 mb-5">
                <i class="fa-solid fa-circle-nodes text-amber-500 mr-1.5"></i>Status armada
            </h2>

            <div class="space-y-4 text-sm">
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-3 text-slate-700">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Tersedia
                    </span>
                    <span class="font-bold text-slate-900">{{ $armadaTersedia }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-3 text-slate-700">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span> Disewa
                    </span>
                    <span class="font-bold text-slate-900">{{ $armadaDisewa }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-3 text-slate-700">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span> Perawatan
                    </span>
                    <span class="font-bold text-slate-900">{{ $armadaPerawatan }}</span>
                </div>
            </div>
        </div>

        @php
            $tot = max($totalArmada, 1);
            $wTersedia = round(($armadaTersedia / $tot) * 100);
            $wDisewa = round(($armadaDisewa / $tot) * 100);
            $wRawat = max(0, 100 - $wTersedia - $wDisewa);
        @endphp
        <div class="mt-6">
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden flex">
                <div class="bg-emerald-500 h-full" style="width: {{ $wTersedia }}%"></div>
                <div class="bg-amber-500 h-full" style="width: {{ $wDisewa }}%"></div>
                <div class="bg-red-500 h-full" style="width: {{ $wRawat }}%"></div>
            </div>
            <p class="text-[11px] text-slate-400 mt-2 text-right">{{ $wTersedia }}% armada siap jalan</p>
        </div>
    </div>
</div>

<!-- baris diagram kedua: buat bantu admin lihat sebaran kategori mobil dan kapasitas tiap cabang -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- diagram jumlah unit per kategori kendaraan -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-sm text-slate-900">
                <i class="fa-solid fa-layer-group text-sky-500 mr-1.5"></i>Diagram Distribusi Kategori Armada
            </h2>
            <span class="text-xs text-slate-500">Komposisi jenis unit</span>
        </div>
        <div class="space-y-3">
            @foreach($categories as $cat)
                @php $pctCat = round(($cat->vehicles_count / max($totalArmada, 1)) * 100); @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="font-semibold text-slate-700">{{ $cat->nama_kategori }}</span>
                        <span class="font-bold text-slate-900">{{ $cat->vehicles_count }} Unit ({{ $pctCat }}%)</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="bg-sky-500 h-full rounded-full" style="width: {{ max($pctCat, $cat->vehicles_count > 0 ? 10 : 0) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- diagram sebaran mobil di tiap cabang ama rasio transmisi matic vs manual -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-bold text-sm text-slate-900">
                    <i class="fa-solid fa-map-location-dot text-amber-500 mr-1.5"></i>Sebaran Armada per Kota Cabang
                </h2>
                <span class="text-xs text-slate-500">Kapasitas cabang</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                @foreach($branches as $br)
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-3">
                        <p class="text-xs text-slate-500 truncate">{{ $br->kota }}</p>
                        <p class="text-lg font-bold text-slate-900 mt-0.5">{{ $br->vehicles_count }} <span class="text-xs font-normal text-slate-500">Unit</span></p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between items-center text-xs">
            <span class="text-slate-500">Rasio Transmisi Armada:</span>
            <div class="flex gap-3 font-semibold">
                <span class="text-amber-600"><i class="fa-solid fa-gears mr-1"></i>Otomatis: {{ $transmisiOtomatis }} Unit</span>
                <span>•</span>
                <span class="text-slate-700">Manual: {{ $transmisiManual }} Unit</span>
            </div>
        </div>
    </div>
</div>

<!-- tabel utama daftar kendaraan -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h2 class="font-bold text-base text-slate-900">Daftar Kendaraan</h2>

        <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
            <form method="GET" action="{{ route('admin.vehicles.index') }}" class="flex flex-wrap items-center gap-2">
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari plat / nama"
                       class="border border-slate-300 bg-slate-50 text-xs px-3.5 py-2 rounded-lg focus:outline-none focus:border-amber-500">

                <select name="category_id" class="border border-slate-300 bg-slate-50 text-xs px-3 py-2 rounded-lg focus:outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nama_kategori }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="border border-slate-300 bg-slate-50 text-xs px-3 py-2 rounded-lg focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    <option value="perawatan" {{ request('status') == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                </select>

                <button type="submit" class="bg-slate-900 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-slate-800 transition">
                    <i class="fa-solid fa-filter mr-1"></i>Filter
                </button>

                @if(request()->hasAny(['q', 'category_id', 'status']))
                    <a href="{{ route('admin.vehicles.index') }}" class="text-xs text-red-600 hover:underline px-2">Reset</a>
                @endif
            </form>

            <a href="{{ route('admin.vehicles.create') }}"
               class="bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold text-xs px-4 py-2 rounded-lg transition shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Kendaraan</span>
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="p-3.5">Kendaraan</th>
                    <th class="p-3.5">Plat</th>
                    <th class="p-3.5">Kategori</th>
                    <th class="p-3.5">Tarif / Hari</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($vehicles as $v)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5">
                            <div class="flex items-center gap-3.5">
                                <img src="{{ $v->foto_url }}"
                                     alt="{{ $v->nama_kendaraan }}"
                                     class="w-16 h-12 object-cover rounded border border-slate-200 bg-slate-100">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $v->nama_kendaraan }}</p>
                                    <p class="text-xs text-slate-500">{{ $v->merek }} • {{ $v->tahun }} • {{ ucfirst($v->transmisi) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-3.5 text-xs font-mono font-semibold text-slate-700">{{ $v->plat_nomor }}</td>
                        <td class="p-3.5 text-xs text-slate-700">
                            <span class="font-semibold">{{ $v->category->nama_kategori }}</span>
                            <span class="block text-[11px] text-slate-500">{{ $v->branch->kota }}</span>
                        </td>
                        <td class="p-3.5 text-xs font-bold text-slate-900">
                            Rp {{ number_format($v->tarif_harian, 0, ',', '.') }}
                        </td>
                        <td class="p-3.5">
                            <span class="text-xs px-2.5 py-1 rounded font-semibold
                                {{ $v->status === 'tersedia' ? 'bg-emerald-100 text-emerald-700' : ($v->status === 'disewa' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                {{ $v->status }}
                            </span>
                        </td>
                        <td class="p-3.5 space-x-2.5 text-xs">
                            <a href="{{ route('admin.vehicles.show', $v->id) }}" class="font-semibold text-slate-700 hover:underline">Lihat</a>
                            <a href="{{ route('admin.vehicles.edit', $v->id) }}" class="font-semibold text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.vehicles.destroy', $v->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus {{ $v->nama_kendaraan }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-semibold text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data kendaraan yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-slate-200">
        {{ $vehicles->links() }}
    </div>
</div>
@endsection