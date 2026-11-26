{{-- resources/views/auth/signup.blade.php --}}
@extends('layouts.app')
@section('title', 'Signup Pelanggan - RiskiMobility')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-4">
    <h1 class="text-xl font-bold text-center">Daftar Akun Pelanggan Baru</h1>
    <form action="{{ route('signup.post') }}" method="POST" class="space-y-3 mt-5 text-sm">
        @csrf
        <div>
            <label class="block text-xs font-semibold mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Nomor HP / WhatsApp</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Nomor SIM Aktif</label>
                <input type="text" name="no_sim" value="{{ old('no_sim') }}" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Alamat Lengkap</label>
            <textarea name="alamat" rows="2" class="w-full border rounded px-3 py-2">{{ old('alamat') }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-semibold mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>
        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-2.5 rounded-lg mt-2">Buat Akun Sekarang</button>
    </form>
</div>
@endsection