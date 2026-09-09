<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null
            && $user->can('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
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
                'unique:products,sku',
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
