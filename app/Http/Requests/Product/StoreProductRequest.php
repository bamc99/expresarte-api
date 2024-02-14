<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['string', 'required'],
            "description" => ['string'],
            "brand" => ['string'],
            "quantity" => ['string'],
            "unit" => ['string'],
            "price" => ['string'],
            "cost" => ['string'],
            "product_category_id" => ['string']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'number' => 'El campo :attribute debe de ser un número'
        ];
    }
}
