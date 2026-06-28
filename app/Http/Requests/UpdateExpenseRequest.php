<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends FormRequest
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
                $expense = $this->route('expense');
                $account = Account::find($this->account_id);

                if ($account) {
                    $availableBalance = $account->balance;

                    // Kalau rekening tidak berubah, jumlah lama dikembalikan dulu sebelum dipotong ulang
                    if ($expense && $account->id === $expense->account_id) {
                        $availableBalance += $expense->amount;
                    }

                    if ($availableBalance < $this->amount) {
                        $validator->errors()->add(
                            'amount',
                            'Saldo rekening tidak cukup. Saldo tersedia: Rp ' . number_format($availableBalance, 0, ',', '.')
                        );
                    }
                }
            }
        });
    }
}