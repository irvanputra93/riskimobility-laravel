@extends('layouts.app')
@section('title', 'Beranda - RiskiMobility')

@section('content')

<!-- yang ini bagian utama, silahkan dikreasikan, kalo mau bikin desain ukurannya di bawah
     Ukuran Background: 1920 x 850 px -->
<div class="w-screen relative left-1/2 -translate-x-1/2 mt-0 mb-10 bg-slate-950 text-white overflow-hidden">
    <div class="relative min-h-[600px] md:min-h-[680px] flex flex-col justify-between bg-cover bg-center bg-no-repeat"
         style="background-image: url('{{ asset('images/cardUtama.png') }}');">

        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/65 to-slate-900/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/40"></div>

        <div class="relative z-10 max-w-7xl mx-auto w-full px-4 md:px-8 pt-16 md:pt-24 pb-10">
            <div class="max-w-2xl">
                <span class="inline-block bg-amber-500 text-slate-950 text-xs font-bold px-3.5 py-1 rounded-full uppercase tracking-wider mb-4">
                    Rental Kendaraan Terpercaya
                </span>

                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight text-white">
                    Teman Terbaik <br>
                    <span class="font-serif italic font-semibold text-sky-200">Setiap Perjalanan</span>
                </h1>

                <p class="text-slate-200 mt-5 text-sm md:text-base leading-relaxed max-w-xl">
                    Pilih armada terbaik, tentukan jadwal penjemputan secara mandiri, dan nikmati transparansi harga tanpa biaya tersembunyi di seluruh jaringan cabang kami.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('bookings.create') }}"
                       class="bg-sky-600 hover:bg-sky-500 text-white px-7 py-3.5 rounded-full font-bold text-sm transition shadow-lg shadow-sky-600/30 flex items-center gap-2">
                        <span>Pesan Sekarang</span>
                        <span>&rarr;</span>
                    </a>
                    <a href="{{ route('produk-jasa') }}"
                       class="bg-slate-900/60 hover:bg-slate-800/80 backdrop-blur-md border border-white/30 text-white px-7 py-3.5 rounded-full font-semibold text-sm transition">
                        Lihat Armada
                    </a>
                </div>
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto w-full px-4 md:px-8 pb-12">
            <div class="bg-slate-900/65 backdrop-blur-md border border-white/15 rounded-2xl px-6 py-6 md:px-10 md:py-7 grid grid-cols-2 md:grid-cols-6 gap-6 md:gap-0 md:divide-x divide-white/15">
                <div class="md:pr-6">
                    <p class="text-2xl md:text-3xl font-extrabold text-white">7<sup class="text-sky-400 text-lg">+</sup></p>
                    <p class="text-[11px] uppercase tracking-widest text-slate-300 mt-1">Kota Cabang</p>
                </div>
                <div class="md:px-6">
                    <p class="text-2xl md:text-3xl font-extrabold text-white">100<sup class="text-sky-400 text-lg">%</sup></p>
                    <p class="text-[11px] uppercase tracking-widest text-slate-300 mt-1">Unit Terawat</p>
                </div>
                <div class="md:px-6">
                    <p class="text-2xl md:text-3xl font-extrabold text-white">{{ $featuredVehicles->count() }}<sup class="text-sky-400 text-lg">+</sup></p>
                    <p class="text-[11px] uppercase tracking-widest text-slate-300 mt-1">Armada Pilihan</p>
                </div>
                <div class="md:px-6">
                    <p class="text-2xl md:text-3xl font-extrabold text-white">4<sup class="text-sky-400 text-lg">+</sup></p>
                    <p class="text-[11px] uppercase tracking-widest text-slate-300 mt-1">Kategori Layanan</p>
                </div>
                <div class="md:px-6">
                    <p class="text-2xl md:text-3xl font-extrabold text-white">1.500<sup class="text-sky-400 text-lg">+</sup></p>
                    <p class="text-[11px] uppercase tracking-widest text-slate-300 mt-1">Pelanggan Puas</p>
                </div>
                <div class="md:pl-6">
                    <p class="text-2xl md:text-3xl font-extrabold text-white">24/7</p>
                    <p class="text-[11px] uppercase tracking-widest text-slate-300 mt-1">Layanan Siaga</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- nah yang ini slider, monggo kreasikan desain kalian (Ukuran Desain: 1280 x 320 px) -->
<div class="relative rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-slate-800 h-[200px] md:h-[320px] mb-10" id="sliderPromo">

    <div class="promo-slide absolute inset-0 transition-opacity duration-500 opacity-100">
        <img src="{{ asset('images/promo1.png') }}"
             alt="Promo 1 RiskiMobility"
             class="w-full h-full object-cover"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="hidden w-full h-full bg-slate-800 text-white p-8 md:p-12 flex-col justify-center">
            <span class="bg-amber-500 text-slate-900 text-xs font-bold px-3 py-1 rounded-full w-fit uppercase">Slide Promo 1</span>
            <h3 class="text-2xl md:text-3xl font-extrabold mt-3">Diskon Spesial Penyewaan Armada RiskiMobility</h3>
            <p class="text-slate-300 text-sm mt-2">Tempatkan file desain Anda di: <strong>public/images/promo1.png</strong> (Ukuran Desain: <strong>1280 x 320 px</strong>)</p>
        </div>
    </div>

    <div class="promo-slide absolute inset-0 transition-opacity duration-500 opacity-0 pointer-events-none">
        <img src="{{ asset('images/promo2.png') }}"
             alt="Promo 2 RiskiMobility"
             class="w-full h-full object-cover"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="hidden w-full h-full bg-slate-800 text-white p-8 md:p-12 flex-col justify-center">
            <span class="bg-amber-500 text-slate-900 text-xs font-bold px-3 py-1 rounded-full w-fit uppercase">Slide Promo 2</span>
            <h3 class="text-2xl md:text-3xl font-extrabold mt-3">Promo Paket Perjalanan Keluarga & Wisata</h3>
            <p class="text-slate-300 text-sm mt-2">Tempatkan file desain Anda di: <strong>public/images/promo2.png</strong> (Ukuran Desain: <strong>1280 x 320 px</strong>)</p>
        </div>
    </div>

    <div class="promo-slide absolute inset-0 transition-opacity duration-500 opacity-0 pointer-events-none">
        <img src="{{ asset('images/promo3.png') }}"
             alt="Promo 3 RiskiMobility"
             class="w-full h-full object-cover"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="hidden w-full h-full bg-slate-800 text-white p-8 md:p-12 flex-col justify-center">
            <span class="bg-amber-500 text-slate-900 text-xs font-bold px-3 py-1 rounded-full w-fit uppercase">Slide Promo 3</span>
            <h3 class="text-2xl md:text-3xl font-extrabold mt-3">Penawaran Hemat Sewa Harian & Mingguan</h3>
            <p class="text-slate-300 text-sm mt-2">Tempatkan file desain Anda di: <strong>public/images/promo3.png</strong> (Ukuran Desain: <strong>1280 x 320 px</strong>)</p>
        </div>
    </div>

    <button type="button" onclick="geserPromo(-1)" class="absolute left-3 top-1/2 -translate-y-1/2 bg-slate-900/70 hover:bg-slate-900 text-white w-8 h-8 rounded-full flex items-center justify-center z-10">
        &#10094;
    </button>
    <button type="button" onclick="geserPromo(1)" class="absolute right-3 top-1/2 -translate-y-1/2 bg-slate-900/70 hover:bg-slate-900 text-white w-8 h-8 rounded-full flex items-center justify-center z-10">
        &#10095;
    </button>

    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
        <button type="button" onclick="pilihPromo(0)" class="promo-dot w-3 h-3 rounded-full bg-amber-500"></button>
        <button type="button" onclick="pilihPromo(1)" class="promo-dot w-3 h-3 rounded-full bg-slate-400"></button>
        <button type="button" onclick="pilihPromo(2)" class="promo-dot w-3 h-3 rounded-full bg-slate-400"></button>
    </div>
</div>

<h2 class="text-xl font-bold mb-4">Layanan Unggulan</h2>
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-12">
    @foreach($serviceTypes as $service)
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <h3 class="font-bold text-slate-900">{{ $service->nama_layanan }}</h3>
            <p class="text-xs text-slate-600 mt-2">{{ $service->deskripsi }}</p>
            <p class="text-xs font-semibold text-amber-600 mt-3">
                {{ $service->dengan_sopir ? '+ Sopir Rp ' . number_format($service->biaya_tambahan_harian, 0, ',', '.') . '/hari' : 'Lepas Kunci (Mandiri)' }}
            </p>
        </div>
    @endforeach
</div>

<!-- ini yang bagian pilihan mobil, kayanya udah aman deh -->
@php
    $daftarKategori = $featuredVehicles->pluck('category.nama_kategori')->filter()->unique()->values();
    $mobilPertama = $featuredVehicles->first();
@endphp

<div class="w-screen relative left-1/2 -translate-x-1/2 bg-[#06152d] text-white py-16 px-4 md:px-8 mb-12">
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end mb-8">
            <div class="md:col-span-7">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-400 mb-2">ARMADA KAMI</p>
                <h2 class="text-3xl md:text-5xl font-serif font-bold leading-tight text-white">
                    Pilihan mobil sewa untuk setiap kebutuhan perjalanan.
                </h2>
            </div>
            <div class="md:col-span-5">
                <p class="text-sm text-slate-300 leading-relaxed">
                    Sewa mobil MPV operasional, SUV, City Car, hingga Minibus pariwisata — semua unit dirawat berkala, siap pakai, dan didukung layanan cabang RiskiMobility.
                </p>
            </div>
        </div>

        <div class="inline-flex flex-wrap items-center gap-1 bg-[#0c2144] border border-white/10 rounded-full p-1.5 mb-8">
            <button type="button"
                    onclick="filterKategoriArmada('SEMUA', this)"
                    class="kategori-pill bg-sky-500 text-white font-semibold text-xs px-5 py-2 rounded-full transition">
                Semua
            </button>
            @foreach($daftarKategori as $kat)
                <button type="button"
                        onclick="filterKategoriArmada('{{ $kat }}', this)"
                        class="kategori-pill text-slate-300 hover:text-white font-medium text-xs px-5 py-2 rounded-full transition">
                    {{ $kat }}
                </button>
            @endforeach
        </div>

        @if($mobilPertama)
            <div class="bg-gradient-to-b from-[#102a52] via-[#0b1f3f] to-[#081730] border border-white/10 rounded-3xl p-6 md:p-10 shadow-2xl mb-6">
                <div class="h-[220px] md:h-[320px] flex items-center justify-center my-2">
                    <img id="mainCarImage"
                         src="{{ $mobilPertama->foto_url }}"
                         alt="{{ $mobilPertama->nama_kendaraan }}"
                         class="max-h-full max-w-full object-contain rounded-xl transition-all duration-300 drop-shadow-2xl">
                </div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mt-6 pt-4 border-t border-white/10">
                    <div>
                        <span id="mainCarCategory" class="text-xs font-bold uppercase tracking-widest text-slate-400">
                            {{ $mobilPertama->category->nama_kategori }} • {{ strtoupper($mobilPertama->transmisi) }} • {{ $mobilPertama->jumlah_kursi }} KURSI
                        </span>
                        <div class="flex flex-wrap items-baseline gap-3 mt-1">
                            <h3 id="mainCarName" class="text-2xl md:text-3xl font-extrabold text-white">
                                {{ $mobilPertama->nama_kendaraan }} ({{ $mobilPertama->tahun }})
                            </h3>
                            <span id="mainCarPrice" class="text-sm font-bold text-amber-400">
                                Rp {{ number_format($mobilPertama->tarif_harian, 0, ',', '.') }} / hari
                            </span>
                        </div>
                        <p id="mainCarDesc" class="text-xs md:text-sm text-slate-300 mt-1.5 max-w-xl">
                            {{ $mobilPertama->deskripsi ?? 'Sewa mobil berkabin lega dan terawat untuk kebutuhan perjalanan harian maupun bisnis.' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" onclick="geserMobilShowcase(-1)"
                                class="w-10 h-10 rounded-full border border-white/25 hover:bg-white/10 flex items-center justify-center text-white transition">
                            &#10094;
                        </button>
                        <button type="button" onclick="geserMobilShowcase(1)"
                                class="w-10 h-10 rounded-full border border-white/25 hover:bg-white/10 flex items-center justify-center text-white transition">
                            &#10095;
                        </button>
                        <a href="{{ route('produk-jasa') }}"
                           class="border border-white/25 hover:bg-white/10 text-white text-xs font-semibold px-5 py-3 rounded-full transition">
                            Lihat Detail
                        </a>
                        <a id="mainCarBookBtn"
                           href="{{ route('bookings.create', ['vehicle_id' => $mobilPertama->id]) }}"
                           class="bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold px-6 py-3 rounded-full shadow-lg shadow-sky-500/30 transition flex items-center gap-1.5">
                            <span>Sewa Unit</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 overflow-x-auto pb-4 pt-1" id="carThumbnailStrip">
                @foreach($featuredVehicles as $idx => $v)
                    <div onclick="pilihMobilShowcase({{ $idx }})"
                         data-index="{{ $idx }}"
                         data-kategori="{{ $v->category->nama_kategori }}"
                         data-nama="{{ $v->nama_kendaraan }} ({{ $v->tahun }})"
                         data-info="{{ $v->category->nama_kategori }} • {{ strtoupper($v->transmisi) }} • {{ $v->jumlah_kursi }} KURSI"
                         data-harga="Rp {{ number_format($v->tarif_harian, 0, ',', '.') }} / hari"
                         data-deskripsi="{{ $v->deskripsi ?? 'Sewa mobil berkabin lega dan terawat untuk kebutuhan perjalanan harian maupun bisnis.' }}"
                         data-foto="{{ $v->foto_url }}"
                         data-sewa="{{ route('bookings.create', ['vehicle_id' => $v->id]) }}"
                         class="car-thumb-card cursor-pointer flex-shrink-0 w-40 md:w-44 rounded-2xl p-3 bg-[#0c1f3d] border transition-all flex flex-col justify-between items-center text-center {{ $idx === 0 ? 'border-sky-400 bg-[#132e59] shadow-md' : 'border-white/10 opacity-75 hover:opacity-100' }}">
                        <img src="{{ $v->foto_url }}"
                             alt="{{ $v->nama_kendaraan }}"
                             class="h-20 w-full object-contain rounded mb-2">
                        <p class="text-xs font-semibold text-white truncate w-full">{{ $v->nama_kendaraan }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-[#0c1f3d] border border-white/10 rounded-2xl p-8 text-center text-slate-300">
                Belum ada unit armada berstatus tersedia. Silakan tambahkan unit di Dashboard Admin.
            </div>
        @endif

        <div class="mt-8 pt-6 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-300">
            <p>Butuh sewa mobil dalam jumlah besar atau model lain? Kami siapkan sesuai kebutuhan perjalanan Anda.</p>
            <a href="{{ route('produk-jasa') }}"
               class="border border-white/25 hover:bg-white/10 text-white font-semibold px-5 py-2.5 rounded-full transition">
                Lihat Semua Armada &rarr;
            </a>
        </div>

    </div>
</div>

<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Jaringan & Kontak Cabang</h2>
        <form method="GET" action="{{ route('beranda') }}" class="flex space-x-2">
            <select name="wilayah" class="border rounded px-3 py-1 text-sm" onchange="this.form.submit()">
                <option value="">Semua Wilayah</option>
                @foreach(['Sumatera', 'Jawa & Bali', 'Kalimantan', 'Sulawesi', 'Lainnya'] as $w)
                    <option value="{{ $w }}" {{ request('wilayah') == $w ? 'selected' : '' }}>{{ $w }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($branches as $b)
            <div class="border rounded-lg p-4 text-sm {{ $b->is_pusat ? 'border-amber-500 bg-amber-50/30' : '' }}">
                <p class="font-bold text-slate-900">{{ $b->nama_cabang }} @if($b->is_pusat) <span class="text-xs bg-amber-500 text-slate-900 px-2 py-0.5 rounded">Pusat</span> @endif</p>
                <p class="text-xs text-slate-600 mt-1">{{ $b->alamat }}</p>
                <p class="text-xs text-slate-700 mt-2">Telp: {{ $b->telepon }} | WA: {{ $b->no_whatsapp }}</p>
            </div>
        @endforeach
    </div>
</div>

<script>
    // ini Script Slider pake 3 Foto Promo, kalo mau di ubah monggo aja
    let indexPromo = 0;
    const slidesPromo = document.querySelectorAll('.promo-slide');
    const dotsPromo = document.querySelectorAll('.promo-dot');

    function tampilkanPromo(n) {
        indexPromo = (n + slidesPromo.length) % slidesPromo.length;
        slidesPromo.forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === indexPromo);
            slide.classList.toggle('opacity-0', i !== indexPromo);
            slide.classList.toggle('pointer-events-none', i !== indexPromo);
        });
        dotsPromo.forEach((dot, i) => {
            dot.classList.toggle('bg-amber-500', i === indexPromo);
            dot.classList.toggle('bg-slate-400', i !== indexPromo);
        });
    }

    function geserPromo(arah) {
        tampilkanPromo(indexPromo + arah);
    }

    function pilihPromo(n) {
        tampilkanPromo(n);
    }

    setInterval(() => {
        geserPromo(1);
    }, 5000);

    // ni bagian bawah Script Interactive Showcase Pilihan Mobil 
    let indexMobilAktif = 0;
    const thumbCards = Array.from(document.querySelectorAll('.car-thumb-card'));

    function pilihMobilShowcase(idx) {
        const visibleThumbs = thumbCards.filter(c => !c.classList.contains('hidden'));
        if (visibleThumbs.length === 0) return;

        const targetCard = thumbCards[idx] && !thumbCards[idx].classList.contains('hidden')
            ? thumbCards[idx]
            : visibleThumbs[0];

        indexMobilAktif = parseInt(targetCard.getAttribute('data-index'));

        document.getElementById('mainCarImage').src = targetCard.getAttribute('data-foto');
        document.getElementById('mainCarImage').alt = targetCard.getAttribute('data-nama');
        document.getElementById('mainCarCategory').textContent = targetCard.getAttribute('data-info');
        document.getElementById('mainCarName').textContent = targetCard.getAttribute('data-nama');
        document.getElementById('mainCarPrice').textContent = targetCard.getAttribute('data-harga');
        document.getElementById('mainCarDesc').textContent = targetCard.getAttribute('data-deskripsi');
        document.getElementById('mainCarBookBtn').href = targetCard.getAttribute('data-sewa');

        thumbCards.forEach(card => {
            const isSelected = parseInt(card.getAttribute('data-index')) === indexMobilAktif;
            card.classList.toggle('border-sky-400', isSelected);
            card.classList.toggle('bg-[#132e59]', isSelected);
            card.classList.toggle('shadow-md', isSelected);
            card.classList.toggle('border-white/10', !isSelected);
            card.classList.toggle('opacity-75', !isSelected);
        });
    }

    function geserMobilShowcase(step) {
        const visibleThumbs = thumbCards.filter(c => !c.classList.contains('hidden'));
        if (visibleThumbs.length === 0) return;

        const currentPos = visibleThumbs.findIndex(c => parseInt(c.getAttribute('data-index')) === indexMobilAktif);
        const nextPos = (currentPos + step + visibleThumbs.length) % visibleThumbs.length;
        const nextRealIndex = parseInt(visibleThumbs[nextPos].getAttribute('data-index'));

        pilihMobilShowcase(nextRealIndex);
    }

    function filterKategoriArmada(kategori, btnEl) {
        document.querySelectorAll('.kategori-pill').forEach(btn => {
            btn.classList.remove('bg-sky-500', 'text-white', 'font-semibold');
            btn.classList.add('text-slate-300', 'font-medium');
        });
        btnEl.classList.add('bg-sky-500', 'text-white', 'font-semibold');
        btnEl.classList.remove('text-slate-300', 'font-medium');

        thumbCards.forEach(card => {
            const katMobil = card.getAttribute('data-kategori');
            if (kategori === 'SEMUA' || katMobil === kategori) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });

        const firstVisible = thumbCards.find(c => !c.classList.contains('hidden'));
        if (firstVisible) {
            pilihMobilShowcase(parseInt(firstVisible.getAttribute('data-index')));
        }
    }
</script>
@endsection