<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'name'=> ['required', 'string'],
            'email'=> ['required', 'email', 'unique:users,email'],
            'password'=> ['required', 'string', 'min:6', 'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'name' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email ya está registrado',
            'password' => 'El password es requerido y debe de tener almenos 6 caracteres',
            'password.confirmed' => 'El password no coincide'
        ];
    }
}
