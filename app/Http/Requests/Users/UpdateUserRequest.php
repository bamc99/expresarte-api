<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['string'],
            'email' => ['string'],
            'password' => ['string', 'min:6'],
            'branch_id' => ['string'],
            'roles' => ['in:Admin,Director,Gerente,Recepcionista,CYT,Marketing,Estilista,Auxiliar'],
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'unique' => 'El valor proporcionado para :attribute ya está en uso.',
            'confirmed' => 'La confirmación de :attribute no coincide.',
            'min' => [
                'string' => 'El campo :attribute debe tener al menos :min caracteres.',
            ],
            'in' => 'El valor seleccionado para :attribute no es válido.',
        ];
    }
}
