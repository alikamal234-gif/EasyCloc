<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRaquest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['min:1','numeric'],
            'paid_at' => ['date'],
            'debtor_id' => ['exists:users,id'],
            'creditor_id' => ['exists:users,id'],
            'flatshare_id' => ['exists:flatshares,id']
        ];
    }
}
