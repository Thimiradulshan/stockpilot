<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePurchaseRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
     *
     * Final authorization is enforced through PurchasePolicy in the
     * controller. This request only confirms that an authenticated
     * user exists.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'purchase_number' => [
                'required',
                'string',
                'max:50',
                'unique:purchases,purchase_number',
            ],

            'supplier_id' => [
                'required',
                'integer',
                Rule::exists(Supplier::class, 'id')
                    ->where(
                        fn ($query) => $query->where(
                            'status',
                            'active'
                        )
                    ),
            ],

            'purchase_date' => [
                'required',
                'date_format:Y-m-d',
            ],

            'discount_amount' => [
                'required',
                'decimal:0,2',
                'min:0',
                'max:999999999999.99',
            ],

            'tax_amount' => [
                'required',
                'decimal:0,2',
                'min:0',
                'max:999999999999.99',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*' => [
                'required',
                'array',
            ],

            'items.*.product_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists(Product::class, 'id')
                    ->where(
                        fn ($query) => $query->where(
                            'status',
                            'active'
                        )
                    ),
            ],

            'items.*.quantity' => [
                'required',
                'decimal:0,3',
                'gt:0',
                'max:999999999999.999',
            ],

            'items.*.unit_cost' => [
                'required',
                'decimal:0,2',
                'gt:0',
                'max:999999999999.99',
            ],

            'items.*.discount_amount' => [
                'nullable',
                'decimal:0,2',
                'min:0',
                'max:999999999999.99',
            ],

            'items.*.tax_amount' => [
                'nullable',
                'decimal:0,2',
                'min:0',
                'max:999999999999.99',
            ],
        ];
    }

    /**
     * Prepare normalized optional monetary values before validation.
     */
    protected function prepareForValidation(): void
    {
        $items = $this->input('items');

        if (is_array($items)) {
            foreach ($items as $index => $item) {
                if (! is_array($item)) {
                    continue;
                }

                $items[$index]['discount_amount']
                    = $item['discount_amount'] ?? '0';

                $items[$index]['tax_amount']
                    = $item['tax_amount'] ?? '0';
            }

            $this->merge([
                'items' => $items,
            ]);
        }
    }
}
