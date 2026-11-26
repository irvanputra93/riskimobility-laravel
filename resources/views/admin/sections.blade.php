@extends('layouts.admin')
@section('title', ucfirst($section) . ' - Admin RiskiMobility')

@section('content')

<!-- ini bagian menu pelanggan, buat ngecek data customer, SIM, sama total pesanannya -->
@if($section === 'customers')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                <i class="fa-solid fa-users text-amber-500 mr-2"></i>Data Pelanggan
            </h1>
            <p class="text-xs text-slate-500 mt-1">Kelola direktori pelanggan terdaftar, nomor SIM, dan histori frekuensi sewa.</p>
        </div>
        <span class="bg-slate-900 text-amber-400 text-xs font-bold px-4 py-2 rounded-lg">
            Total: {{ $customers->count() }} Pelanggan
        </span>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="p-3.5">Nama & Email</th>
                    <th class="p-3.5">No. HP / WhatsApp</th>
                    <th class="p-3.5">Nomor SIM</th>
                    <th class="p-3.5">Alamat</th>
                    <th class="p-3.5">Total Pesanan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($customers as $c)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3.5">
                            <p class="font-bold text-slate-900">{{ $c->user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $c->user->email }}</p>
                        </td>
                        <td class="p-3.5 text-xs font-medium">{{ $c->no_hp }}</td>
                        <td class="p-3.5 text-xs font-mono">{{ $c->no_sim }}</td>
                        <td class="p-3.5 text-xs text-slate-600">{{ $c->alamat ?? '-' }}</td>
                        <td class="p-3.5">
                            <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                {{ $c->bookings->count() }}x Transaksi
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-6 text-center text-slate-400">Belum ada pelanggan terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

<!-- ni bagian menu pemesanan, jadi atmin bisa konfirmasi jadwal dan pilihkan sopir -->
@if($section === 'bookings')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                <i class="fa-solid fa-calendar-check text-amber-500 mr-2"></i>Manajemen Pemesanan
            </h1>
            <p class="text-xs text-slate-500 mt-1">Konfirmasi jadwal sewa, pasangkan sopir untuk layanan dengan pengemudi, dan pantau pengembalian unit.</p>
        </div>
        <div class="flex flex-wrap gap-2 text-xs">
            <a href="{{ route('admin.bookings') }}" class="px-3.5 py-1.5 rounded-lg border {{ !request('status') ? 'bg-slate-900 text-white font-semibold' : 'bg-white text-slate-600' }}">Semua</a>
            @foreach(['menunggu', 'dikonfirmasi', 'berjalan', 'selesai', 'dibatalkan'] as $st)
                <a href="{{ route('admin.bookings', ['status' => $st]) }}"
                   class="px-3.5 py-1.5 rounded-lg border {{ request('status') === $st ? 'bg-amber-500 text-slate-900 font-bold border-amber-500' : 'bg-white text-slate-600' }}">
                    {{ ucfirst($st) }} ({{ $bookingCounts[$st] ?? 0 }})
                </a>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="p-3.5">Kode & Jadwal</th>
                    <th class="p-3.5">Pelanggan</th>
                    <th class="p-3.5">Kendaraan & Layanan</th>
                    <th class="p-3.5">Sopir</th>
                    <th class="p-3.5">Total Tagihan</th>
                    <th class="p-3.5">Status & Tindakan Admin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($bookings as $b)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3.5 text-xs">
                            <span class="font-mono font-bold text-slate-900 bg-amber-100 px-2.5 py-1 rounded">{{ $b->kode_booking }}</span>
                            <p class="text-slate-500 mt-1.5">{{ $b->tanggal_ambil->format('d M Y') }} - {{ $b->tanggal_kembali->format('d M Y') }} ({{ $b->durasi_hari }} hr)</p>
                        </td>
                        <td class="p-3.5 text-xs">
                            <p class="font-bold text-slate-900">{{ $b->customer->user->name }}</p>
                            <p class="text-slate-500">Cabang: {{ $b->pickupBranch->kota }}</p>
                        </td>
                        <td class="p-3.5 text-xs">
                            <p class="font-bold text-slate-900">{{ $b->vehicle->nama_kendaraan }}</p>
                            <p class="text-slate-500">{{ $b->serviceType->nama_layanan }}</p>
                        </td>
                        <td class="p-3.5 text-xs">
                            @if($b->driver)
                                <span class="font-semibold text-emerald-700"><i class="fa-solid fa-id-badge mr-1"></i>{{ $b->driver->nama }}</span>
                            @elseif($b->serviceType->dengan_sopir)
                                <span class="text-amber-600 font-medium">Perlu Sopir</span>
                            @else
                                <span class="text-slate-400">Lepas Kunci</span>
                            @endif
                        </td>
                        <td class="p-3.5 text-xs font-bold text-slate-900">
                            Rp {{ number_format($b->total_bayar, 0, ',', '.') }}
                        </td>
                        <td class="p-3.5 text-xs">
                            <form action="{{ route('admin.bookings.update-status', $b->id) }}" method="POST" class="flex flex-wrap items-center gap-1.5">
                                @csrf @method('PATCH')
                                @if($b->serviceType->dengan_sopir && !$b->driver_id)
                                    <select name="driver_id" class="border border-slate-300 rounded px-2 py-1 text-xs bg-slate-50">
                                        <option value="">-- Pilih Sopir --</option>
                                        @foreach($drivers as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <select name="status" class="border border-slate-300 rounded px-2 py-1 text-xs bg-white font-semibold">
                                    @foreach(['menunggu', 'dikonfirmasi', 'berjalan', 'selesai', 'dibatalkan'] as $st)
                                        <option value="{{ $st }}" {{ $b->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-slate-900 text-white px-3 py-1 rounded hover:bg-slate-800">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-slate-400">Belum ada data pemesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

<!-- yang ini buat menu pembayaran, buat ngecek foto bukti transfer dari pelanggan -->
@if($section === 'payments')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">
            <i class="fa-solid fa-file-invoice-dollar text-amber-500 mr-2"></i>Verifikasi Pembayaran
        </h1>
        <p class="text-xs text-slate-500 mt-1">Periksa unggahan foto bukti transfer pelanggan dan validasi status lunas.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs text-slate-500">Total Pembayaran Lunas</p>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">Rp {{ number_format($paymentSummary['lunas'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs text-slate-500">Menunggu Verifikasi Admin</p>
            <p class="text-2xl font-extrabold text-amber-600 mt-1">Rp {{ number_format($paymentSummary['menunggu'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <p class="text-xs text-slate-500">Distribusi Metode Pembayaran</p>
            <div class="flex justify-between text-xs font-bold text-slate-800 mt-2">
                <span>Transfer: {{ $paymentSummary['transfer'] }}</span>
                <span>E-Wallet: {{ $paymentSummary['ewallet'] }}</span>
                <span>Tunai: {{ $paymentSummary['tunai'] }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-xs uppercase text-slate-600">
                <tr>
                    <th class="p-3.5">Kode Booking</th>
                    <th class="p-3.5">Pelanggan & Kendaraan</th>
                    <th class="p-3.5">Metode & Nominal</th>
                    <th class="p-3.5">Foto Bukti Bayar</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5">Aksi Verifikasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($payments as $p)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3.5 font-mono font-bold text-xs">{{ $p->booking->kode_booking }}</td>
                        <td class="p-3.5 text-xs">
                            <p class="font-bold text-slate-900">{{ $p->booking->customer->user->name }}</p>
                            <p class="text-slate-500">{{ $p->booking->vehicle->nama_kendaraan }}</p>
                        </td>
                        <td class="p-3.5 text-xs">
                            <span class="uppercase font-semibold">{{ $p->metode }}</span>
                            <p class="font-bold text-slate-900 mt-0.5">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</p>
                        </td>
                        <td class="p-3.5 text-xs">
                            @if($p->bukti_bayar_url)
                                <a href="{{ $p->bukti_bayar_url }}" target="_blank" class="text-blue-600 underline font-semibold">
                                    <i class="fa-solid fa-image mr-1"></i>Lihat Foto Struk
                                </a>
                            @else
                                <span class="text-slate-400">File seeder ({{ $p->bukti_bayar }})</span>
                            @endif
                        </td>
                        <td class="p-3.5">
                            <span class="text-xs px-2.5 py-1 rounded font-bold uppercase
                                {{ $p->status === 'lunas' ? 'bg-emerald-100 text-emerald-700' : ($p->status === 'menunggu' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="p-3.5 text-xs space-x-2">
                            @if($p->status === 'menunggu')
                                <form action="{{ route('admin.payments.verify', $p->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="lunas">
                                    <button class="bg-emerald-600 text-white px-3 py-1 rounded font-bold hover:bg-emerald-500">Terima (Lunas)</button>
                                </form>
                                <form action="{{ route('admin.payments.verify', $p->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button class="bg-red-600 text-white px-3 py-1 rounded font-bold hover:bg-red-500">Tolak</button>
                                </form>
                            @else
                                <span class="text-slate-400">Diverifikasi oleh {{ $p->verifier->name ?? 'Admin' }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-slate-400">Belum ada transaksi pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

<!-- ni bagian menu laporan, rekap pemasukan sewa dikurangi biaya bengkel perawatan -->
@if($section === 'reports')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                <i class="fa-solid fa-chart-line text-amber-500 mr-2"></i>Laporan Keuangan & Operasional
            </h1>
            <p class="text-xs text-slate-500 mt-1">Rekapitulasi pemasukan sewa dibandingkan biaya perawatan unit armada.</p>
        </div>
        <button onclick="window.print()" class="bg-slate-900 text-amber-400 text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-print"></i>
            <span>Cetak Laporan</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs text-slate-500">Total Pemasukan Sewa (Lunas)</p>
            <p class="text-2xl font-extrabold text-emerald-600 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs text-slate-500">Total Beban Perawatan Armada</p>
            <p class="text-2xl font-extrabold text-red-600 mt-1">Rp {{ number_format($totalBiayaPerawatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-slate-900 text-white p-5 rounded-xl shadow-sm">
            <p class="text-xs text-slate-400">Estimasi Laba Operasional Bersih</p>
            <p class="text-2xl font-extrabold text-amber-400 mt-1">Rp {{ number_format($labaBersih, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h2 class="font-bold text-sm text-slate-900 mb-3">Riwayat Transaksi Sewa Aktif & Selesai</h2>
            <table class="w-full text-left text-xs">
                <thead class="border-b text-slate-500">
                    <tr><th class="py-2">Kode</th><th class="py-2">Unit</th><th class="py-2">Durasi</th><th class="py-2 text-right">Total</th></tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($completedBookings as $cb)
                        <tr>
                            <td class="py-2.5 font-mono font-bold">{{ $cb->kode_booking }}</td>
                            <td class="py-2.5">{{ $cb->vehicle->nama_kendaraan }}</td>
                            <td class="py-2.5">{{ $cb->durasi_hari }} hari</td>
                            <td class="py-2.5 text-right font-bold text-slate-900">Rp {{ number_format($cb->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h2 class="font-bold text-sm text-slate-900 mb-3">Riwayat Pengeluaran Perawatan Kendaraan</h2>
            <table class="w-full text-left text-xs">
                <thead class="border-b text-slate-500">
                    <tr><th class="py-2">Unit</th><th class="py-2">Jenis Servis</th><th class="py-2">Status</th><th class="py-2 text-right">Biaya</th></tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($maintenances as $m)
                        <tr>
                            <td class="py-2.5 font-bold text-slate-900">{{ $m->vehicle->nama_kendaraan }}</td>
                            <td class="py-2.5">{{ $m->jenis_perawatan }}</td>
                            <td class="py-2.5 uppercase">{{ $m->status }}</td>
                            <td class="py-2.5 text-right font-bold text-red-600">Rp {{ number_format($m->biaya, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<!-- ni buat menu pengaturan operasional, bisa kelola sopir, jadwal bengkel, sama tambah kategori baru -->
@if($section === 'settings')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">
            <i class="fa-solid fa-sliders text-amber-500 mr-2"></i>Pengaturan Operasional
        </h1>
        <p class="text-xs text-slate-500 mt-1">Kelola personel sopir, catat jadwal perawatan armada (servis), dan tambah kategori kendaraan baru.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- form buat daftar supir -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="font-bold text-base text-slate-900 mb-4"><i class="fa-solid fa-id-card text-amber-500 mr-2"></i>1. Manajemen Personel Sopir</h2>
            <form action="{{ route('admin.settings.drivers.store') }}" method="POST" class="grid grid-cols-2 gap-3 text-xs mb-5 bg-slate-50 p-4 rounded-xl border border-slate-200">
                @csrf
                <input type="text" name="nama" placeholder="Nama Lengkap Sopir" class="border border-slate-300 rounded-lg px-3 py-2 bg-white" required>
                <input type="text" name="no_hp" placeholder="Nomor HP Sopir" class="border border-slate-300 rounded-lg px-3 py-2 bg-white" required>
                <input type="text" name="no_sim" placeholder="Nomor SIM A/B1" class="border border-slate-300 rounded-lg px-3 py-2 bg-white" required>
                <select name="status" class="border border-slate-300 rounded-lg px-3 py-2 bg-white">
                    <option value="tersedia">Tersedia</option>
                    <option value="bertugas">Bertugas</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                <button type="submit" class="col-span-2 bg-slate-900 text-amber-400 font-bold py-2 rounded-lg hover:bg-slate-800">+ Tambah Sopir Baru</button>
            </form>

            <div class="space-y-2 text-xs">
                @foreach($drivers as $d)
                    <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                        <div>
                            <p class="font-bold text-slate-900">{{ $d->nama }}</p>
                            <p class="text-slate-500">HP: {{ $d->no_hp }} • SIM: {{ $d->no_sim }}</p>
                        </div>
                        <form action="{{ route('admin.settings.drivers.update', $d->id) }}" method="POST" class="flex gap-1.5">
                            @csrf @method('PATCH')
                            <select name="status" class="border border-slate-300 rounded px-2 py-1 text-xs bg-white" onchange="this.form.submit()">
                                @foreach(['tersedia', 'bertugas', 'nonaktif'] as $st)
                                    <option value="{{ $st }}" {{ $d->status === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- form pencatatan perawatan mobil ke bengkel -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="font-bold text-base text-slate-900 mb-4"><i class="fa-solid fa-screwdriver-wrench text-amber-500 mr-2"></i>2. Pencatatan Perawatan Armada</h2>
            <form action="{{ route('admin.settings.maintenances.store') }}" method="POST" class="grid grid-cols-2 gap-3 text-xs mb-5 bg-slate-50 p-4 rounded-xl border border-slate-200">
                @csrf
                <select name="vehicle_id" class="col-span-2 border border-slate-300 rounded-lg px-3 py-2 bg-white" required>
                    <option value="">-- Pilih Kendaraan yang Masuk Bengkel --</option>
                    @foreach($vehicles as $v)
                        <option value="{{ $v->id }}">{{ $v->nama_kendaraan }} ({{ $v->plat_nomor }}) - Status: {{ $v->status }}</option>
                    @endforeach
                </select>
                <input type="text" name="jenis_perawatan" placeholder="Contoh: Ganti Oli & Kampas Rem" class="border border-slate-300 rounded-lg px-3 py-2 bg-white" required>
                <input type="date" name="tanggal_mulai" value="{{ date('Y-m-d') }}" class="border border-slate-300 rounded-lg px-3 py-2 bg-white" required>
                <input type="number" name="biaya" placeholder="Biaya Servis (Rp)" class="col-span-2 border border-slate-300 rounded-lg px-3 py-2 bg-white" required>
                <button type="submit" class="col-span-2 bg-amber-500 text-slate-900 font-bold py-2 rounded-lg hover:bg-amber-400">Catat Servis & Set Status Perawatan</button>
            </form>

            <div class="space-y-2 text-xs">
                @foreach($maintenances as $m)
                    <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                        <div>
                            <p class="font-bold text-slate-900">{{ $m->vehicle->nama_kendaraan }} — {{ $m->jenis_perawatan }}</p>
                            <p class="text-slate-500">Biaya: Rp {{ number_format($m->biaya, 0, ',', '.') }} • Status: <strong>{{ strtoupper($m->status) }}</strong></p>
                        </div>
                        @if($m->status !== 'selesai')
                            <form action="{{ route('admin.settings.maintenances.complete', $m->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="bg-emerald-600 text-white px-3 py-1 rounded font-semibold hover:bg-emerald-500">Selesai Servis</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- buat nambah kategori baru, siapa tau mau nambah kapal induk -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
        <h2 class="font-bold text-base text-slate-900 mb-4"><i class="fa-solid fa-tags text-amber-500 mr-2"></i>3. Kategori Kendaraan Terdaftar</h2>
        <form action="{{ route('admin.settings.categories.store') }}" method="POST" class="flex flex-wrap gap-3 text-xs mb-4">
            @csrf
            <input type="text" name="nama_kategori" placeholder="Nama Kategori Baru (Contoh: Luxury / Heavy Tank)" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi singkat kategori..." class="border border-slate-300 rounded-lg px-3 py-2 flex-1">
            <button type="submit" class="bg-slate-900 text-white px-5 py-2 rounded-lg font-bold hover:bg-slate-800">+ Tambah Kategori</button>
        </form>
        <div class="flex flex-wrap gap-2">
            @foreach($categories as $c)
                <span class="bg-slate-100 border border-slate-200 text-slate-800 text-xs px-3.5 py-1.5 rounded-full font-semibold">
                    {{ $c->nama_kategori }} ({{ $c->vehicles_count }} Unit)
                </span>
            @endforeach
        </div>
    </div>
@endif

@endsection