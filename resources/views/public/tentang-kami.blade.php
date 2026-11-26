{{-- resources/views/public/tentang-kami.blade.php --}}
@extends('layouts.app')
@section('title', 'Tentang Kami - RiskiMobility')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200 space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Tentang RiskiMobility</h1>
        <p class="text-sm text-slate-600 mt-2 leading-relaxed">
            RiskiMobility hadir dengan slogan <strong>"Teman Terbaik Setiap Perjalanan"</strong> sebagai solusi penyewaan kendaraan terintegrasi berbasis web yang mengutamakan transparansi harga, kepastian jadwal ketersediaan armada, dan perawatan berkala.
        </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-slate-50 p-5 rounded-lg border">
            <h2 class="font-bold text-lg mb-2">Visi Perusahaan</h2>
            <p class="text-sm text-slate-700">Menjadi penyedia layanan rental kendaraan yang terpercaya, profesional, dan mudah diakses untuk memenuhi berbagai kebutuhan perjalanan masyarakat.</p>
        </div>
        <div class="bg-slate-50 p-5 rounded-lg border">
            <h2 class="font-bold text-lg mb-2">Nilai Perusahaan (Core Values)</h2>
            <ul class="text-sm text-slate-700 space-y-1 list-disc list-inside">
                <li><strong>Trustworthy:</strong> Harga selalu tampil jelas sebelum memesan.</li>
                <li><strong>Comfort:</strong> Unit nyaman dengan jadwal perawatan tercatat.</li>
                <li><strong>Reliability:</strong> Pelayanan konsisten dan tepat waktu.</li>
                <li><strong>Customer First:</strong> Kebutuhan pelanggan menjadi prioritas utama.</li>
            </ul>
        </div>
    </div>
</div>
@endsection