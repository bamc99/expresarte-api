<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientProfileRequest extends FormRequest
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
            'client_id' => ['required', 'string'],

            'first_name' => ['string'],
            'middle_name' => ['string'],
            'last_name' => ['string'],
            'second_last_name' => ['string'],

            'street' => ['string'],
            'house_number' => ['string'],
            'neighborhood' => ['string'],
            'city' => ['string'],
            'state' => ['string'],
            'postal_code' => ['string'],
            'country' => ['string'],

            'phone' => ['string'],

            'date_of_birth' => ['date'],
            'date_of_first_visit' => ['date'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
        ];
    }
}
