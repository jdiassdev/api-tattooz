<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductsListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug'      => ['nullable', 'string', 'exists:products,slug'],
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.exists'       => 'Produto não encontrado.',
            'price_min.numeric' => 'Preço mínimo deve ser numérico.',
            'price_max.numeric' => 'Preço máximo deve ser numérico.',
        ];
    }
}
