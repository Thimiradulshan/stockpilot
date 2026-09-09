<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $product = $this->route('product');
        $user = $this->user();

        return $user !== null
            && $product instanceof Product
            && $user->can('update', $product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'name' => [
                'required',
                'string',
                'max:200',
            ],
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore(
                    $product instanceof Product ? $product->getKey() : null,
                ),
            ],
            'cost_price' => [
                'required',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],
            'reorder_level' => [
                'required',
                'numeric',
                'min:0',
                'decimal:0,3',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ];
    }
}
