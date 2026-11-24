<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Maintenance;
use App\Models\Payment;
use App\Models\ServiceType;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    private function getMonthlyRevenueChart(): array
    {
        $months = [
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
        ];

        $baseline = [5 => 42.0, 6 => 51.5, 7 => 48.0, 8 => 64.2, 9 => 59.0, 10 => 67.5, 11 => 75.0];
        $chart = [];

        foreach ($months as $num => $label) {
            $actual = Payment::where('status', 'lunas')
                ->whereMonth('tanggal_bayar', $num)
                ->sum('jumlah');

            $valJuta = $actual > 0 ? round($actual / 1000000, 2) : 0;
            $displayVal = max($baseline[$num], $valJuta + ($num === 11 ? $baseline[11] : 0));

            $chart[] = [
                'label'      => $label,
                'actual_rp'  => $actual,
                'juta'       => $valJuta > 0 ? $valJuta : $baseline[$num],
                'height_pct' => min(100, max(25, round(($displayVal / 90) * 100))),
                'is_current' => $num === 11,
            ];
        }

        return $chart;
    }

    /** halaman utama dashboard atmin ygy */
    public function dashboard(Request $request)
    {
        $totalPendapatan = Payment::where('status', 'lunas')->sum('jumlah');
        $totalArmada = Vehicle::count();
        $armadaTersedia = Vehicle::where('status', 'tersedia')->count();
        $armadaDisewa = Vehicle::where('status', 'disewa')->count();
        $armadaPerawatan = Vehicle::where('status', 'perawatan')->count();

        $revenueChart = $this->getMonthlyRevenueChart();

        $bookingStats = [
            'menunggu'     => Booking::where('status', 'menunggu')->count(),
            'dikonfirmasi' => Booking::where('status', 'dikonfirmasi')->count(),
            'berjalan'     => Booking::where('status', 'berjalan')->count(),
            'selesai'      => Booking::where('status', 'selesai')->count(),
            'dibatalkan'   => Booking::where('status', 'dibatalkan')->count(),
        ];
        $totalBookings = array_sum($bookingStats);

        $driverStats = [
            'tersedia' => Driver::where('status', 'tersedia')->count(),
            'bertugas' => Driver::where('status', 'bertugas')->count(),
            'nonaktif' => Driver::where('status', 'nonaktif')->count(),
        ];

        $categoryStats = Category::withCount('vehicles')->get();
        $topVehicles = Vehicle::with('category')
            ->withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();

        $vehicles = Vehicle::with(['category', 'branch'])->latest()->paginate(10);
        $recentBookings = Booking::with(['customer.user', 'vehicle', 'driver', 'payments'])->latest()->take(6)->get();
        $drivers = Driver::where('status', 'tersedia')->get();

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalArmada',
            'armadaTersedia',
            'armadaDisewa',
            'armadaPerawatan',
            'revenueChart',
            'bookingStats',
            'totalBookings',
            'driverStats',
            'categoryStats',
            'topVehicles',
            'vehicles',
            'recentBookings',
            'drivers'
        ));
    }

    /** menu kendaraan, diagram dan lain lain */
    public function index(Request $request)
    {
        $query = Vehicle::with(['category', 'branch']);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($sub) use ($search) {
                $sub->where('nama_kendaraan', 'like', "%{$search}%")
                    ->orWhere('plat_nomor', 'like', "%{$search}%")
                    ->orWhere('merek', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::withCount('vehicles')->get();
        $branches = Branch::withCount('vehicles')->get();

        // Statistik Kartu & Diagram Menu Kendaraan
        $totalArmada = Vehicle::count();
        $armadaTersedia = Vehicle::where('status', 'tersedia')->count();
        $armadaDisewa = Vehicle::where('status', 'disewa')->count();
        $armadaPerawatan = Vehicle::where('status', 'perawatan')->count();

        $pesananHariIni = Booking::whereDate('created_at', today())->count();
        $menungguKonfirmasi = Booking::where('status', 'menunggu')->count();
        $totalPendapatan = Payment::where('status', 'lunas')->sum('jumlah');

        $revenueChart = $this->getMonthlyRevenueChart();
        $transmisiOtomatis = Vehicle::where('transmisi', 'otomatis')->count();
        $transmisiManual = Vehicle::where('transmisi', 'manual')->count();

        return view('admin.vehicles.index', compact(
            'vehicles',
            'categories',
            'branches',
            'totalArmada',
            'armadaTersedia',
            'armadaDisewa',
            'armadaPerawatan',
            'pesananHariIni',
            'menungguKonfirmasi',
            'totalPendapatan',
            'revenueChart',
            'transmisiOtomatis',
            'transmisiManual'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        $branches = Branch::all();

        return view('admin.vehicles.create', compact('categories', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'branch_id'      => 'required|exists:branches,id',
            'nama_kendaraan' => 'required|string|max:100',
            'merek'          => 'required|string|max:50',
            'plat_nomor'     => 'required|string|max:15|unique:vehicles,plat_nomor',
            'tahun'          => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'warna'          => 'required|string|max:30',
            'transmisi'      => 'required|in:manual,otomatis',
            'jumlah_kursi'   => 'required|integer|min:1|max:50',
            'tarif_harian'   => 'required|numeric|min:0',
            'status'         => 'required|in:tersedia,disewa,perawatan',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'      => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('vehicles', 'public');
        }

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Data armada kendaraan berhasil ditambahkan!');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['category', 'branch', 'maintenances', 'bookings.customer.user']);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $categories = Category::all();
        $branches = Branch::all();

        return view('admin.vehicles.edit', compact('vehicle', 'categories', 'branches'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'branch_id'      => 'required|exists:branches,id',
            'nama_kendaraan' => 'required|string|max:100',
            'merek'          => 'required|string|max:50',
            'plat_nomor'     => 'required|string|max:15|unique:vehicles,plat_nomor,' . $vehicle->id,
            'tahun'          => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'warna'          => 'required|string|max:30',
            'transmisi'      => 'required|in:manual,otomatis',
            'jumlah_kursi'   => 'required|integer|min:1|max:50',
            'tarif_harian'   => 'required|numeric|min:0',
            'status'         => 'required|in:tersedia,disewa,perawatan',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'      => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            if ($vehicle->foto && Storage::disk('public')->exists($vehicle->foto)) {
                Storage::disk('public')->delete($vehicle->foto);
            }
            $validated['foto'] = $request->file('foto')->store('vehicles', 'public');
        }

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan ' . $vehicle->nama_kendaraan . ' berhasil diperbarui!');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->bookings()->exists()) {
            return back()->with('error', 'Kendaraan ini sudah memiliki riwayat pesanan. Silakan ubah statusnya saja agar riwayat transaksi tetap utuh.');
        }

        if ($vehicle->foto && Storage::disk('public')->exists($vehicle->foto)) {
            Storage::disk('public')->delete($vehicle->foto);
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan berhasil dihapus secara permanen.');
    }

    /** buat ngelola data pelanggan */
    public function customers(Request $request)
    {
        $section = 'customers';
        $customers = Customer::with(['user', 'bookings'])
            ->when($request->q, function ($q) use ($request) {
                $q->where('no_hp', 'like', "%{$request->q}%")
                  ->orWhere('no_sim', 'like', "%{$request->q}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->q}%")->orWhere('email', 'like', "%{$request->q}%"));
            })
            ->latest()
            ->get();

        return view('admin.sections', compact('section', 'customers'));
    }

    /** kelola pemesanan ama supir */
    public function adminBookings(Request $request)
    {
        $section = 'bookings';
        $bookings = Booking::with(['customer.user', 'vehicle', 'serviceType', 'pickupBranch', 'driver', 'payments'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->q, fn($q) => $q->where('kode_booking', 'like', "%{$request->q}%"))
            ->latest()
            ->get();

        $drivers = Driver::where('status', 'tersedia')->get();
        $bookingCounts = [
            'menunggu'     => Booking::where('status', 'menunggu')->count(),
            'dikonfirmasi' => Booking::where('status', 'dikonfirmasi')->count(),
            'berjalan'     => Booking::where('status', 'berjalan')->count(),
            'selesai'      => Booking::where('status', 'selesai')->count(),
            'dibatalkan'   => Booking::where('status', 'dibatalkan')->count(),
        ];

        return view('admin.sections', compact('section', 'bookings', 'drivers', 'bookingCounts'));
    }

    /** ini kelola ama verifikasi pembayaran */
    public function adminPayments(Request $request)
    {
        $section = 'payments';
        $payments = Payment::with(['booking.customer.user', 'booking.vehicle', 'verifier'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        $paymentSummary = [
            'lunas'    => Payment::where('status', 'lunas')->sum('jumlah'),
            'menunggu' => Payment::where('status', 'menunggu')->sum('jumlah'),
            'ditolak'  => Payment::where('status', 'ditolak')->sum('jumlah'),
            'transfer' => Payment::where('metode', 'transfer')->count(),
            'ewallet'  => Payment::where('metode', 'e-wallet')->count(),
            'tunai'    => Payment::where('metode', 'tunai')->count(),
        ];

        return view('admin.sections', compact('section', 'payments', 'paymentSummary'));
    }

    /** ini laporan pendapatan sama perawatan armada kita */
    public function reports()
    {
        $section = 'reports';
        $totalPemasukan = Payment::where('status', 'lunas')->sum('jumlah');
        $totalBiayaPerawatan = Maintenance::sum('biaya');
        $labaBersih = $totalPemasukan - $totalBiayaPerawatan;

        $completedBookings = Booking::with(['customer.user', 'vehicle', 'serviceType'])
            ->whereIn('status', ['berjalan', 'selesai'])
            ->latest()
            ->get();

        $maintenances = Maintenance::with('vehicle')->latest()->get();
        $revenueChart = $this->getMonthlyRevenueChart();

        return view('admin.sections', compact(
            'section',
            'totalPemasukan',
            'totalBiayaPerawatan',
            'labaBersih',
            'completedBookings',
            'maintenances',
            'revenueChart'
        ));
    }

    /** ni menu operasional, kayak Kategori, Sopir, Perawatan, & Cabang */
    public function settings()
    {
        $section = 'settings';
        $categories = Category::withCount('vehicles')->get();
        $drivers = Driver::latest()->get();
        $maintenances = Maintenance::with('vehicle')->latest()->get();
        $vehicles = Vehicle::all();
        $branches = Branch::all();
        $serviceTypes = ServiceType::all();

        return view('admin.sections', compact(
            'section',
            'categories',
            'drivers',
            'maintenances',
            'vehicles',
            'branches',
            'serviceTypes'
        ));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:categories,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ]);

        Category::create($validated);
        return back()->with('success', 'Kategori kendaraan baru berhasil ditambahkan!');
    }

    public function storeDriver(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'no_hp'  => 'required|string|max:20',
            'no_sim' => 'required|string|max:20',
            'status' => 'required|in:tersedia,bertugas,nonaktif',
        ]);

        Driver::create($validated);
        return back()->with('success', 'Data sopir baru berhasil ditambahkan!');
    }

    public function updateDriverStatus(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'status' => 'required|in:tersedia,bertugas,nonaktif',
        ]);

        $driver->update($validated);
        return back()->with('success', 'Status sopir ' . $driver->nama . ' berhasil diperbarui!');
    }

    public function storeMaintenance(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'jenis_perawatan' => 'required|string|max:100',
            'tanggal_mulai'   => 'required|date',
            'biaya'           => 'required|numeric|min:0',
            'keterangan'      => 'nullable|string',
        ]);

        $validated['status'] = 'proses';
        Maintenance::create($validated);

        Vehicle::where('id', $validated['vehicle_id'])->update(['status' => 'perawatan']);

        return back()->with('success', 'Jadwal perawatan dicatat dan status kendaraan otomatis diubah menjadi Perawatan.');
    }

    public function completeMaintenance(Maintenance $maintenance)
    {
        $maintenance->update([
            'status'          => 'selesai',
            'tanggal_selesai' => today(),
        ]);

        $maintenance->vehicle->update(['status' => 'tersedia']);

        return back()->with('success', 'Perawatan selesai! Kendaraan ' . $maintenance->vehicle->nama_kendaraan . ' kembali Tersedia.');
    }
}