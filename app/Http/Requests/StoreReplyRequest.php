<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'isi'    => ['required', 'string', 'max:2000'],
            'status' => ['nullable', Rule::in(Ticket::STATUS)],
        ];
    }

    public function messages(): array
    {
        return [
            'isi.required' => 'Isi balasan wajib diisi.',
            'isi.max'      => 'Balasan maksimal 2000 karakter.',
            'status.in'    => 'Status tidak valid.',
        ];
    }
}