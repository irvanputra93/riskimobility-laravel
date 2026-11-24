<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// route public buat user biasa
Route::get('/', [PublicPageController::class, 'beranda'])->name('beranda');
Route::get('/tentang-kami', [PublicPageController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/produk-dan-jasa', [PublicPageController::class, 'produkDanJasa'])->name('produk-jasa');

// route autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// route penyewaan pelanggan, btw ini wajib login, bisa customer atau admin
Route::middleware(['auth', 'role:customer,admin'])->group(function () {
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/payments', [PaymentController::class, 'store'])->name('payments.store');
});

// route atmin, aku atmin kau member, sumpah banyak banget, makasih system analyst :)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [VehicleController::class, 'dashboard'])->name('dashboard');
    Route::resource('vehicles', VehicleController::class);
    Route::get('/customers', [VehicleController::class, 'customers'])->name('customers');
    Route::get('/bookings', [VehicleController::class, 'adminBookings'])->name('bookings');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::get('/payments', [VehicleController::class, 'adminPayments'])->name('payments');
    Route::patch('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::get('/reports', [VehicleController::class, 'reports'])->name('reports');
    Route::get('/settings', [VehicleController::class, 'settings'])->name('settings');
    Route::post('/settings/categories', [VehicleController::class, 'storeCategory'])->name('settings.categories.store');
    Route::post('/settings/drivers', [VehicleController::class, 'storeDriver'])->name('settings.drivers.store');
    Route::patch('/settings/drivers/{driver}', [VehicleController::class, 'updateDriverStatus'])->name('settings.drivers.update');
    Route::post('/settings/maintenances', [VehicleController::class, 'storeMaintenance'])->name('settings.maintenances.store');
    Route::patch('/settings/maintenances/{maintenance}/complete', [VehicleController::class, 'completeMaintenance'])->name('settings.maintenances.complete');
});