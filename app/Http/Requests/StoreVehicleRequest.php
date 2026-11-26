<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        $vehicleId = $this->route('vehicle')?->id;

        return [
            'category_id'    => 'required|exists:categories,id',
            'branch_id'      => 'required|exists:branches,id',
            'nama_kendaraan' => 'required|string|max:100',
            'merek'          => 'required|string|max:50',
            'plat_nomor'     => 'required|string|max:15|unique:vehicles,plat_nomor,' . $vehicleId,
            'tahun'          => 'required|integer|min:2010|max:' . (date('Y') + 1),
            'warna'          => 'required|string|max:30',
            'transmisi'      => 'required|in:manual,otomatis',
            'jumlah_kursi'   => 'required|integer|min:2|max:30',
            'tarif_harian'   => 'required|numeric|min:50000',
            'status'         => 'required|in:tersedia,disewa,perawatan',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'      => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'plat_nomor.unique'  => 'Plat nomor kendaraan ini sudah terdaftar di database RiskiMobility.',
            'tarif_harian.min'   => 'Tarif sewa harian minimal adalah Rp 50.000.',
            'foto.image'         => 'File foto kendaraan yang diunggah harus berupa gambar.',
            'foto.mimes'         => 'Format foto mobil hanya mendukung JPEG, PNG, JPG, atau WEBP.',
            'foto.max'           => 'Ukuran file foto mobil maksimal adalah 2 MB (2048 KB).',
        ];
    }
}