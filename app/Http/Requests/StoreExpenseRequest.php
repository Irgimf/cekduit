<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'account_id' => [
                'required',
                Rule::exists('accounts', 'id')->where('user_id', $userId),
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('user_id', $userId)->where('type', 'expense'),
            ],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
            'transaction_date' => ['required', 'date'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($this->filled('account_id') && $this->filled('amount')) {
                $account = Account::find($this->account_id);

                if ($account && $account->balance < $this->amount) {
                    $validator->errors()->add(
                        'amount',
                        'Saldo rekening tidak cukup. Saldo saat ini: Rp ' . number_format($account->balance, 0, ',', '.')
                    );
                }
            }
        });
    }
}