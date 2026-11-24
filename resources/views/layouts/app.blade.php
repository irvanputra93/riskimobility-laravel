<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RiskiMobility - Teman Terbaik Setiap Perjalanan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col overflow-x-hidden">

    <!-- ini bagian navbar ya ges ya -->
    <nav class="bg-slate-900 text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('beranda') }}" class="text-xl font-bold tracking-wide text-amber-400">
                RiskiMobility
                <span class="block text-xs font-normal text-slate-300">Teman Terbaik Setiap Perjalanan</span>
            </a>

            <div class="flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('beranda') }}" class="hover:text-amber-400">Beranda</a>
                <a href="{{ route('tentang-kami') }}" class="hover:text-amber-400">Tentang Kami</a>
                <a href="{{ route('produk-jasa') }}" class="hover:text-amber-400">Produk & Jasa</a>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-amber-500 text-slate-900 px-3 py-1.5 rounded font-semibold hover:bg-amber-400">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('bookings.create') }}" class="hover:text-amber-400">Sewa Mobil</a>
                        <a href="{{ route('bookings.index') }}" class="hover:text-amber-400">Riwayat Sewa</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-400 hover:text-red-300 ml-2">
                            Logout ({{ auth()->user()->name }})
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-amber-400">Login</a>
                    <a href="{{ route('signup') }}" class="bg-amber-500 text-slate-900 px-4 py-1.5 rounded font-semibold hover:bg-amber-400">
                        Signup
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    @if(session('success') || session('error') || $errors->any())
        <div class="{{ request()->routeIs('beranda') ? 'fixed top-20 right-4 z-50 w-full max-w-md px-4 shadow-lg' : 'max-w-7xl mx-auto w-full px-4 mt-4' }}">
            @if(session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-600 text-emerald-800 p-4 rounded mb-4 flex justify-between items-center">
                    <span><strong>Berhasil!</strong> {{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-600 text-red-800 p-4 rounded mb-4">
                    <span><strong>Perhatian!</strong> {{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <p class="font-bold text-sm mb-1">Terdapat kesalahan pada input form:</p>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- nah yang ini konten utama -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 {{ request()->routeIs('beranda') ? 'pb-6 pt-0' : 'py-6' }}">
        @yield('content')
    </main>

    <!-- footer gess, aku bingung mau ngasih apa di footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <p>&copy; {{ date('Y') }} <strong>RiskiMobility</strong> — Teman Terbaik Setiap Perjalanan.</p>
            <p>Kantor Pusat: Yogyakarta | Layanan 24 Jam</p>
        </div>
    </footer>

</body>
</html>