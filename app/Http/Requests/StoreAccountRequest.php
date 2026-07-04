<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:100'],
            'type'           => ['required', 'in:cash,bank,e_wallet'],
            'account_number' => ['nullable', 'string', 'max:50'],
            'admin_fee'      => ['nullable', 'numeric', 'min:0'],
        ];
    }
}