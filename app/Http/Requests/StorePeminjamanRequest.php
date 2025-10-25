<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kamu bisa ubah sesuai sistem role kamu
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'barang' => ['required', 'array', 'min:1'],
            'barang.*.commodity_id' => ['required', 'exists:commodities,id'],
            'barang.*.jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah tanggal pinjam.',
            'barang.required' => 'Minimal pilih satu barang untuk dipinjam.',
            'barang.*.commodity_id.exists' => 'Barang yang dipilih tidak valid.',
            'barang.*.jumlah.min' => 'Jumlah minimal 1.',
        ];
    }
}
