<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - RiskiMobility')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex">

    <!-- intinya ini bagian sidebar atmin -->
    <aside class="w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col justify-between min-h-screen sticky top-0 h-screen shadow-xl">
        <div>

            <div class="px-6 pt-6 pb-6 flex items-center gap-3.5 border-b border-slate-800">
                <div class="w-10 h-10 rounded-lg bg-amber-500 text-slate-900 font-extrabold text-xl flex items-center justify-center flex-shrink-0 shadow">
                    R
                </div>
                <div>
                    <a href="{{ route('beranda') }}" class="font-bold text-lg tracking-wide text-amber-400 block leading-none hover:text-amber-300 transition">
                        RiskiMobility
                    </a>
                    <span class="text-[11px] text-slate-400 block mt-1">Teman Terbaik Setiap Perjalanan</span>
                </div>
            </div>

            <nav class="px-4 py-6 space-y-1.5 text-sm">
                @php
                    $menus = [
                        ['label' => 'Dashboard',  'icon' => 'fa-solid fa-gauge-high',          'route' => 'admin.dashboard',  'active' => request()->routeIs('admin.dashboard')],
                        ['label' => 'Kendaraan',  'icon' => 'fa-solid fa-car-side',            'route' => 'admin.vehicles.*', 'url' => route('admin.vehicles.index'), 'active' => request()->routeIs('admin.vehicles.*')],
                        ['label' => 'Pelanggan',  'icon' => 'fa-solid fa-users',               'route' => 'admin.customers',  'active' => request()->routeIs('admin.customers')],
                        ['label' => 'Pemesanan',  'icon' => 'fa-solid fa-calendar-check',      'route' => 'admin.bookings',   'active' => request()->routeIs('admin.bookings')],
                        ['label' => 'Pembayaran', 'icon' => 'fa-solid fa-file-invoice-dollar', 'route' => 'admin.payments',   'active' => request()->routeIs('admin.payments')],
                        ['label' => 'Laporan',    'icon' => 'fa-solid fa-chart-line',          'route' => 'admin.reports',    'active' => request()->routeIs('admin.reports')],
                        ['label' => 'Pengaturan', 'icon' => 'fa-solid fa-sliders',             'route' => 'admin.settings',   'active' => request()->routeIs('admin.settings')],
                    ];
                @endphp

                @foreach($menus as $m)
                    <a href="{{ $m['url'] ?? route($m['route']) }}"
                       class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition font-medium {{ $m['active'] ? 'bg-amber-500 text-slate-900 font-bold shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="{{ $m['icon'] }} w-5 text-center {{ $m['active'] ? 'text-slate-900' : 'text-amber-400' }}"></i>
                        <span>{{ $m['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="p-4 border-t border-slate-800 space-y-2 text-xs">
            <a href="{{ route('beranda') }}" class="flex items-center justify-between px-4 py-2.5 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white transition">
                <span><i class="fa-solid fa-globe mr-2 text-amber-400"></i>Lihat Website Publik</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2.5 rounded-lg text-red-400 hover:bg-slate-800 transition font-medium">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout ({{ auth()->user()->name ?? 'Admin' }})
                </button>
            </form>
        </div>
    </aside>

    <!-- ni bagian sebelah kanan buat topbar pencarian dan isi konten halaman -->
    <div class="flex-1 flex flex-col min-w-0">

        <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center sticky top-0 z-40 shadow-sm">
            <form action="{{ route('admin.vehicles.index') }}" method="GET" class="w-full max-w-md relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari kendaraan, pelanggan, pesanan..."
                       class="w-full bg-slate-100 text-sm text-slate-800 placeholder-slate-400 pl-10 pr-5 py-2 rounded-full border border-transparent focus:border-amber-500 focus:bg-white focus:outline-none transition">
            </form>

            <div class="flex items-center gap-4">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500" title="Sistem Online"></span>
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-slate-900 text-amber-400 font-bold text-sm flex items-center justify-center">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="text-sm font-semibold text-slate-800">{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </header>

        <!-- ni buat pesan sukses atau error validasi (jiahhh cari validasi) -->
        <div class="px-8 pt-5">
            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-600 text-emerald-800 p-4 rounded mb-4 text-sm flex justify-between items-center">
                    <span><i class="fa-solid fa-circle-check mr-2"></i><strong>Berhasil!</strong> {{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-600 text-red-800 p-4 rounded mb-4 text-sm">
                    <span><i class="fa-solid fa-triangle-exclamation mr-2"></i><strong>Perhatian!</strong> {{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <p class="font-bold mb-1">Terdapat kesalahan pada input form:</p>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- ini konten menu admin -->
        <main class="flex-1 px-8 py-6">
            @yield('content')
        </main>
    </div>

</body>
</html>