<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect sesuai role pengguna
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
            }

            return redirect()->route('beranda')->with('success', 'Login berhasil! Selamat datang di RiskiMobility.');
        }

        return back()->withInput()->with('error', 'Email atau password yang Anda masukkan salah.');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:users,email',
            'no_hp'    => 'required|string|max:20',
            'no_sim'   => 'required|string|max:20',
            'alamat'   => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = DB::transaction(function () use ($validated) {
            $newUser = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'customer',
            ]);

            Customer::create([
                'user_id' => $newUser->id,
                'no_hp'   => $validated['no_hp'],
                'no_sim'  => $validated['no_sim'],
                'alamat'  => $validated['alamat'] ?? null,
            ]);

            return $newUser;
        });

        Auth::login($user);

        return redirect()->route('beranda')->with('success', 'Pendaftaran akun berhasil! Sekarang Anda dapat menyewa kendaraan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}