<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'       => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'prioritas'   => ['required', Rule::in(Ticket::PRIORITAS)],
            'deskripsi'   => ['required', 'string', 'min:10'],
            'lampiran' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'       => 'Judul keluhan wajib diisi.',
            'judul.max'            => 'Judul maksimal 150 karakter.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'prioritas.required'   => 'Prioritas wajib dipilih.',
            'prioritas.in'         => 'Prioritas tidak valid.',
            'deskripsi.required'   => 'Deskripsi keluhan wajib diisi.',
            'deskripsi.min'        => 'Deskripsi minimal 10 karakter.',
            'lampiran.image'    => 'Lampiran harus berupa gambar.',
            'lampiran.mimes'    => 'Format lampiran harus JPG atau PNG.',
            'lampiran.max'      => 'Ukuran lampiran maksimal 2 MB.',
            'lampiran.uploaded' => 'Lampiran gagal diunggah. Pastikan ukurannya tidak melebihi batas server.',
        ];
    }
}