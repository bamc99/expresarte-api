<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'street' => ['required', 'string'],
            'house_number' => ['required', 'string'],
            'interior_number' => ['string'],
            'neighborhood' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
            'country' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
        ];
    }

    /**
     * Get the validation attributes that should be used to display the validation error messages.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'nombre',
            'street' => 'calle',
            'house_number' => 'número de casa',
            'interior_number' => 'número interior',
            'neighborhood' => 'colonia',
            'city' => 'ciudad',
            'state' => 'estado',
            'postal_code' => 'código postal',
            'country' => 'país',
        ];
    }
}
