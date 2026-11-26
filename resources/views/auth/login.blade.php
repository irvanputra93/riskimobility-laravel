{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')
@section('title', 'Login - RiskiMobility')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-sm border border-slate-200 mt-8">
    <h1 class="text-xl font-bold text-center">Masuk ke RiskiMobility</h1>
    <p class="text-xs text-slate-500 text-center mt-1">Gunakan email dan password akun Anda</p>

    <form action="{{ route('login.post') }}" method="POST" class="space-y-4 mt-6 text-sm">
        @csrf
        <div>
            <label class="block text-xs font-semibold mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" class="w-full bg-amber-500 text-slate-900 font-bold py-2 rounded-lg">Login</button>
    </form>
</div>
@endsection