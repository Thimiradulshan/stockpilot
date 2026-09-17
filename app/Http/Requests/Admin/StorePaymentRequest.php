<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
     *
     * Final authorization is enforced through the payment policy in
     * the controller. This request only confirms that an authenticated
     * user exists.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * The idempotency key is optional at the HTTP layer; the controller
     * generates one when the form does not supply a key.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'decimal:0,2',
                'gt:0',
                'max:999999999999.99',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:30',
                Rule::in(['cash', 'card', 'bank_transfer', 'credit']),
            ],

            'idempotency_key' => [
                'nullable',
                'string',
                'max:100',
            ],
        ];
    }
}
