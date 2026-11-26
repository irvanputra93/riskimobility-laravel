@extends('layouts.admin')
@section('title', 'Dashboard Operasional Admin - RiskiMobility')

@section('content')
<!-- bagian judul atas halaman dashboard dan tombol tambah armada -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Dashboard Operasional Admin</h1>
        <p class="text-xs text-slate-500 mt-1">Ringkasan performa bisnis, diagram analitik armada, dan pemantauan transaksi harian RiskiMobility.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.reports') }}" class="border border-slate-300 bg-white text-slate-700 px-4 py-2 rounded-lg text-xs font-semibold hover:bg-slate-100 transition flex items-center gap-2">
            <i class="fa-solid fa-file-lines"></i>
            <span>Lihat Laporan</span>
        </a>
        <a href="{{ route('admin.vehicles.create') }}" class="bg-amber-500 text-slate-900 px-4 py-2 rounded-lg text-xs font-bold hover:bg-amber-400 transition shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Armada Baru</span>
        </a>
    </div>
</div>

<!-- 4 kartu ringkasan di bagian atas dashboard, warnanya pakai tone awal kita -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex justify-between items-start">
        <div>
            <p class="text-xs text-slate-500">Total Pendapatan (Lunas)</p>
            <p class="text-xl font-extrabold text-emerald-600 mt-1">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </p>
            <p class="text-[11px] text-slate-400 mt-1">Pembayaran terverifikasi</p>
        </div>
        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <i class="fa-solid fa-sack-dollar text-lg"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex justify-between items-start">
        <div>
            <p class="text-xs text-slate-500">Armada Tersedia</p>
            <p class="text-xl font-extrabold text-slate-900 mt-1">
                {{ $armadaTersedia }} / {{ $totalArmada }} Unit
            </p>
            <p class="text-[11px] text-slate-400 mt-1">Siap disewakan hari ini</p>
        </div>
        <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-800 flex items-center justify-center">
            <i class="fa-solid fa-car text-lg"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex justify-between items-start">
        <div>
            <p class="text-xs text-slate-500">Sedang Disewa</p>
            <p class="text-xl font-extrabold text-amber-600 mt-1">
                {{ $armadaDisewa }} Unit
            </p>
            <p class="text-[11px] text-slate-400 mt-1">
                {{ $totalArmada > 0 ? round(($armadaDisewa / $totalArmada) * 100) : 0 }}% dari total armada
            </p>
        </div>
        <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
            <i class="fa-solid fa-key text-lg"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex justify-between items-start">
        <div>
            <p class="text-xs text-slate-500">Dalam Perawatan</p>
            <p class="text-xl font-extrabold text-red-600 mt-1">
                {{ $armadaPerawatan }} Unit
            </p>
            <p class="text-[11px] text-slate-400 mt-1">Servis & pengecekan bengkel</p>
        </div>
        <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
            <i class="fa-solid fa-screwdriver-wrench text-lg"></i>
        </div>
    </div>
</div>

<!-- baris diagram pertama: grafik batang pendapatan 7 bulan sama status armada dan sopir -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">

    <!-- diagram batang pendapatan 7 bulan terakhir buat mantau tren pemasukan -->
    <div class="lg:col-span-8 bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="font-bold text-sm text-slate-900">
                    <i class="fa-solid fa-chart-column text-amber-500 mr-1.5"></i>Pendapatan 7 bulan terakhir (juta rupiah)
                </h2>
                <p class="text-xs text-slate-500">Tren pemasukan bulanan RiskiMobility (Mei – November)</p>
            </div>
            <span class="text-xs bg-amber-100 text-amber-800 px-3 py-1 rounded-full font-semibold">
                Bulan Ini: {{ end($revenueChart)['juta'] }} jt
            </span>
        </div>

        <div class="h-52 flex items-end justify-between gap-4 pt-6 px-2 border-b border-slate-100 pb-3">
            @foreach($revenueChart as $bar)
                <div class="flex-1 flex flex-col items-center group">
                    <span class="text-[11px] font-bold text-slate-600 mb-1.5 opacity-85 group-hover:opacity-100">
                        {{ $bar['juta'] }}jt
                    </span>
                    <div class="w-full max-w-[54px] rounded-t-lg transition-all duration-300 {{ $bar['is_current'] ? 'bg-amber-500' : 'bg-slate-300 group-hover:bg-slate-400' }}"
                         style="height: {{ $bar['height_pct'] * 1.45 }}px;">
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between gap-4 px-2 pt-2.5 text-xs text-slate-500">
            @foreach($revenueChart as $bar)
                <div class="flex-1 text-center {{ $bar['is_current'] ? 'font-bold text-slate-900' : '' }}">
                    {{ $bar['label'] }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- diagram status armada dan kesiapan sopir -->
    <div class="lg:col-span-4 bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <div>
            <h2 class="font-bold text-sm text-slate-900 mb-4">
                <i class="fa-solid fa-chart-pie text-amber-500 mr-1.5"></i>Status Armada & Sopir
            </h2>
            <div class="space-y-3.5 text-sm">
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2.5 text-slate-700">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Tersedia
                    </span>
                    <span class="font-bold text-slate-900">{{ $armadaTersedia }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2.5 text-slate-700">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span> Disewa
                    </span>
                    <span class="font-bold text-slate-900">{{ $armadaDisewa }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="flex items-center gap-2.5 text-slate-700">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span> Perawatan
                    </span>
                    <span class="font-bold text-slate-900">{{ $armadaPerawatan }}</span>
                </div>
            </div>

            @php
                $totA = max($totalArmada, 1);
                $pctTersedia = round(($armadaTersedia / $totA) * 100);
                $pctDisewa   = round(($armadaDisewa / $totA) * 100);
                $pctRawat    = max(0, 100 - $pctTersedia - $pctDisewa);
            @endphp
            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden flex mt-5">
                <div class="bg-emerald-500 h-full" style="width: {{ $pctTersedia }}%" title="Tersedia {{ $pctTersedia }}%"></div>
                <div class="bg-amber-500 h-full" style="width: {{ $pctDisewa }}%" title="Disewa {{ $pctDisewa }}%"></div>
                <div class="bg-red-500 h-full" style="width: {{ $pctRawat }}%" title="Perawatan {{ $pctRawat }}%"></div>
            </div>
        </div>

        <!-- kotak kecil buat ngecek jumlah sopir yang lagi kosong atau bertugas -->
        <div class="mt-6 pt-5 border-t border-slate-100">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Kesiapan Personel Sopir</p>
            <div class="grid grid-cols-3 gap-2 text-center">
                <div class="bg-slate-50 border border-slate-200 p-2.5 rounded-lg">
                    <p class="text-lg font-bold text-emerald-600">{{ $driverStats['tersedia'] }}</p>
                    <p class="text-[11px] text-slate-500">Siaga</p>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-2.5 rounded-lg">
                    <p class="text-lg font-bold text-amber-600">{{ $driverStats['bertugas'] }}</p>
                    <p class="text-[11px] text-slate-500">Bertugas</p>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-2.5 rounded-lg">
                    <p class="text-lg font-bold text-slate-500">{{ $driverStats['nonaktif'] }}</p>
                    <p class="text-[11px] text-slate-500">Off</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- baris diagram kedua: buat bantu admin lihat antrean status booking sama mobil paling laku -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <!-- diagram komposisi status pesanan -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="font-bold text-sm text-slate-900">
                    <i class="fa-solid fa-bars-progress text-sky-500 mr-1.5"></i>Diagram Alur Status Pesanan
                </h2>
                <p class="text-xs text-slate-500">Pantau antrean pesanan yang butuh konfirmasi & pengembalian</p>
            </div>
            <span class="text-xs font-bold bg-slate-100 text-slate-700 px-3 py-1 rounded-full">Total: {{ $totalBookings }} Pesanan</span>
        </div>

        @php
            $totB = max($totalBookings, 1);
            $statusItems = [
                ['key' => 'menunggu',     'label' => 'Menunggu Konfirmasi', 'color' => 'bg-amber-500',   'count' => $bookingStats['menunggu']],
                ['key' => 'dikonfirmasi', 'label' => 'Dikonfirmasi',        'color' => 'bg-sky-500',     'count' => $bookingStats['dikonfirmasi']],
                ['key' => 'berjalan',     'label' => 'Sedang Berjalan',     'color' => 'bg-indigo-500',  'count' => $bookingStats['berjalan']],
                ['key' => 'selesai',      'label' => 'Selesai',             'color' => 'bg-emerald-500', 'count' => $bookingStats['selesai']],
                ['key' => 'dibatalkan',   'label' => 'Dibatalkan',          'color' => 'bg-red-500',     'count' => $bookingStats['dibatalkan']],
            ];
        @endphp

        <div class="space-y-3 mt-4">
            @foreach($statusItems as $item)
                @php $pct = round(($item['count'] / $totB) * 100); @endphp
                <div>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="font-medium text-slate-700">{{ $item['label'] }}</span>
                        <span class="font-bold text-slate-900">{{ $item['count'] }} ({{ $pct }}%)</span>
                    </div>
                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="{{ $item['color'] }} h-full rounded-full" style="width: {{ max($pct, $item['count'] > 0 ? 8 : 0) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- diagram 5 mobil yang paling sering disewa pelanggan -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="font-bold text-sm text-slate-900">
                    <i class="fa-solid fa-ranking-star text-amber-500 mr-1.5"></i>Utilisasi Armada Terpopuler
                </h2>
                <p class="text-xs text-slate-500">Frekuensi penyewaan tertinggi per unit kendaraan</p>
            </div>
            <a href="{{ route('admin.vehicles.index') }}" class="text-xs text-sky-600 font-semibold hover:underline">Detail Armada &rarr;</a>
        </div>

        <div class="space-y-3 mt-4">
            @php $maxBook = max($topVehicles->max('bookings_count') ?? 1, 1); @endphp
            @foreach($topVehicles as $tv)
                @php $barW = max(15, round(($tv->bookings_count / $maxBook) * 100)); @endphp
                <div class="flex items-center gap-3 text-xs">
                    <img src="{{ $tv->foto_url }}" alt="{{ $tv->nama_kendaraan }}" class="w-10 h-8 object-cover rounded border bg-slate-100 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between mb-1">
                            <span class="font-bold text-slate-800 truncate">{{ $tv->nama_kendaraan }} <span class="font-normal text-slate-400">({{ $tv->category->nama_kategori }})</span></span>
                            <span class="font-semibold text-amber-600">{{ $tv->bookings_count }}x disewa</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-full rounded-full" style="width: {{ $barW }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- tabel master armada kendaraan -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
    <div class="p-4 border-b flex justify-between items-center">
        <h2 class="font-bold text-slate-900">Data Master Armada Kendaraan</h2>
        <a href="{{ route('admin.vehicles.index') }}" class="text-xs font-semibold text-sky-600 hover:underline">
            Buka Menu Kendaraan Penuh &rarr;
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="p-3">Foto</th>
                    <th class="p-3">Kendaraan</th>
                    <th class="p-3">Kategori & Cabang</th>
                    <th class="p-3">Tarif/Hari</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi CRUD</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($vehicles as $v)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3">
                            <img src="{{ $v->foto_url }}" alt="{{ $v->nama_kendaraan }}" class="w-16 h-12 object-cover rounded border bg-slate-100">
                        </td>
                        <td class="p-3">
                            <p class="font-bold text-slate-900">{{ $v->nama_kendaraan }}</p>
                            <p class="text-xs text-slate-500">{{ $v->plat_nomor }} • {{ $v->tahun }}</p>
                        </td>
                        <td class="p-3 text-xs text-slate-600">{{ $v->category->nama_kategori }} ({{ $v->branch->kota }})</td>
                        <td class="p-3 font-semibold text-slate-900">Rp {{ number_format($v->tarif_harian, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="text-xs px-2.5 py-0.5 rounded font-semibold
                                {{ $v->status === 'tersedia' ? 'bg-emerald-100 text-emerald-700' : ($v->status === 'disewa' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                {{ $v->status }}
                            </span>
                        </td>
                        <td class="p-3 space-x-2 text-xs">
                            <a href="{{ route('admin.vehicles.show', $v->id) }}" class="text-slate-700 hover:underline font-medium">Lihat</a>
                            <a href="{{ route('admin.vehicles.edit', $v->id) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('admin.vehicles.destroy', $v->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kendaraan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ni tabel pesanan terbaru ama verifikasi bukti bayar.. jangan lupa sewa mobil biar kami kaya-->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center">
        <h2 class="font-bold text-slate-900">Pesanan Terbaru & Verifikasi Pembayaran</h2>
        <a href="{{ route('admin.bookings') }}" class="text-xs font-semibold text-sky-600 hover:underline">
            Kelola Semua Pesanan &rarr;
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Pelanggan & Unit</th>
                    <th class="p-3">Total & Bukti Bayar</th>
                    <th class="p-3">Status Sewa</th>
                    <th class="p-3">Tindakan Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($recentBookings as $b)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-mono font-bold">{{ $b->kode_booking }}</td>
                        <td class="p-3 text-xs">
                            <p class="font-bold text-slate-900">{{ $b->customer->user->name }}</p>
                            <p class="text-slate-500">{{ $b->vehicle->nama_kendaraan }} ({{ $b->durasi_hari }} hari)</p>
                        </td>
                        <td class="p-3 text-xs">
                            <p class="font-bold text-slate-900">Rp {{ number_format($b->total_bayar, 0, ',', '.') }}</p>
                            @php $pay = $b->payments->last(); @endphp
                            @if($pay)
                                <a href="{{ $pay->bukti_bayar_url }}" target="_blank" class="text-blue-600 underline">Lihat Foto Bukti ({{ $pay->status }})</a>
                                @if($pay->status === 'menunggu')
                                    <form action="{{ route('admin.payments.verify', $pay->id) }}" method="POST" class="inline ml-2">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="lunas">
                                        <button class="bg-emerald-600 text-white px-2 py-0.5 rounded text-[11px]">Set Lunas</button>
                                    </form>
                                @endif
                            @else
                                <span class="text-slate-400">Belum upload bukti</span>
                            @endif
                        </td>
                        <td class="p-3 text-xs font-bold uppercase">{{ $b->status }}</td>
                        <td class="p-3 text-xs">
                            <form action="{{ route('admin.bookings.update-status', $b->id) }}" method="POST" class="flex space-x-1">
                                @csrf @method('PATCH')
                                <select name="status" class="border rounded px-2 py-1 text-xs bg-white">
                                    <option value="dikonfirmasi" {{ $b->status == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="berjalan" {{ $b->status == 'berjalan' ? 'selected' : '' }}>Berjalan (Serahkan Unit)</option>
                                    <option value="selesai" {{ $b->status == 'selesai' ? 'selected' : '' }}>Selesai (Unit Kembali)</option>
                                    <option value="dibatalkan" {{ $b->status == 'dibatalkan' ? 'selected' : '' }}>Batalkan</option>
                                </select>
                                <button type="submit" class="bg-slate-900 text-white px-2.5 py-1 rounded hover:bg-slate-800">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection