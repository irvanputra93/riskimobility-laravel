<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'vehicle_id'       => 'required|exists:vehicles,id',
            'service_type_id'  => 'required|exists:service_types,id',
            'pickup_branch_id' => 'required|exists:branches,id',
            'tanggal_ambil'    => 'required|date|after_or_equal:today',
            'jam_ambil'        => 'required',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_ambil',
            'jam_kembali'      => 'required',
            'catatan'          => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_id.required'            => 'Silakan pilih unit kendaraan yang ingin disewa.',
            'tanggal_ambil.after_or_equal'   => 'Tanggal pengambilan kendaraan tidak boleh di masa lalu.',
            'tanggal_kembali.after_or_equal' => 'Tanggal pengembalian harus sama atau setelah tanggal pengambilan.',
        ];
    }
}