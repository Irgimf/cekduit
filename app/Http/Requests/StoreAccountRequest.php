<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // otorisasi dicek lewat AccountPolicy di controller
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:cash,bank,e_wallet'],
            'balance' => ['required', 'numeric', 'min:0'],
        ];
    }
}