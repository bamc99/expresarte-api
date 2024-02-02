<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'middle_name' => ['string'],
            'last_name' => ['required', 'string'],
            'second_last_name' => ['required', 'string'],

            'email' => ['required', 'string', 'unique:users,email'],

            'password' => ['required', 'string', 'min:6'],

            'street' => ['required', 'string'],
            'house_number' => ['required', 'string'],
            'neighborhood' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
            'country' => ['required', 'string'],

            'phone' => ['required', 'string'],

            'date_of_birth' => ['required', 'date'],
            'date_of_first_visit' => ['required', 'date'],

        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'unique' => 'El valor proporcionado para :attribute ya está en uso.',
            'confirmed' => 'La confirmación de :attribute no coincide.',
            'min' => [
                'string' => 'El campo :attribute debe tener al menos :min caracteres.',
            ],
            'date' => 'El campo :attribute debe ser una fecha válida.',
            'in' => 'El valor seleccionado para :attribute no es válido.',

            // Ajusta el siguiente bloque según tus campos específicos
            'first_name.required' => 'El campo Nombre es obligatorio.',
            'last_name.required' => 'El campo Apellido es obligatorio.',
            'second_last_name.required' => 'El campo Segundo apellido es obligatorio.',
            'email.required' => 'El campo Correo electrónico es obligatorio.',
            'password.required' => 'El campo Contraseña es obligatorio.',
            'street.required' => 'El campo Calle es obligatorio.',
            'house_number.required' => 'El campo Número de casa es obligatorio.',
            'neighborhood.required' => 'El campo Colonia es obligatorio.',
            'city.required' => 'El campo Ciudad es obligatorio.',
            'state.required' => 'El campo Estado es obligatorio.',
            'postal_code.required' => 'El campo Código postal es obligatorio.',
            'country.required' => 'El campo País es obligatorio.',
            'phone.required' => 'El campo Teléfono es obligatorio.',
            'date_of_birth.required' => 'El campo Fecha de nacimiento es obligatorio.',
            'date_of_first_visit.required' => 'El campo Fecha de primera visita es obligatorio.'
        ];
    }
}
