<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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

            'emergency_name' => ['required', 'string'],
            'emergency_phone' => ['required', 'string'],
            'emergency_relationship' => ['required', 'string'],

            'date_of_birth' => ['required', 'date'],
            'date_of_hire' => ['required', 'date'],

            'nss' => ['required', 'string'],

            'branch_id' => ['required', 'string'],

            'roles' => ['required', 'in:Admin,Director,Gerente,Recepcionista,CYT,Marketing,Estilista,Auxiliar'],
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
            'emergency_name.required' => 'El campo Nombre de contacto de emergencia es obligatorio.',
            'emergency_phone.required' => 'El campo Teléfono de contacto de emergencia es obligatorio.',
            'emergency_relationship.required' => 'El campo Relación de contacto de emergencia es obligatorio.',
            'date_of_birth.required' => 'El campo Fecha de nacimiento es obligatorio.',
            'date_of_hire.required' => 'El campo Fecha de contratación es obligatorio.',
            'nss.required' => 'El campo NSS es obligatorio.',
            'branch_id.required' => 'El campo ID de sucursal es obligatorio.',
            'roles.required' => 'El campo Roles es obligatorio.',
        ];
    }
}
