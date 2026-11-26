<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\ServiceType;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function beranda(Request $request)
    {
        $serviceTypes = ServiceType::all();
        $featuredVehicles = Vehicle::with(['category', 'branch'])->where('status', 'tersedia')->take(6)->get();
        $branches = Branch::when($request->wilayah, fn($q) => $q->where('wilayah', $request->wilayah))->get();

        return view('public.beranda', compact('serviceTypes', 'featuredVehicles', 'branches'));
    }

    public function tentangKami()
    {
        return view('public.tentang-kami');
    }

    public function produkDanJasa(Request $request)
    {
        $categories = Category::all();
        $serviceTypes = ServiceType::all();

        $vehicles = Vehicle::with(['category', 'branch'])
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->transmisi, fn($q) => $q->where('transmisi', $request->transmisi))
            ->get();

        return view('public.produk-jasa', compact('categories', 'serviceTypes', 'vehicles'));
    }
}