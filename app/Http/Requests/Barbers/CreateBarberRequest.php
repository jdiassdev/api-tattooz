<?php

namespace App\Http\Requests\Barbers;

use Illuminate\Foundation\Http\FormRequest;

class CreateBarberRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'cpf'   => 'required|string|max:14',
            'phone' => 'required|string|max:20',
            'about' => 'required|string|max:500',

            'specialties' => 'required|array',
            'specialties.*' => 'string|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email é obrigatório',
            'email.email' => 'Email inválido',
            'email.exists' => 'Usuário não encontrado',

            'cpf.required' => 'CPF é obrigatório',
            'cpf.string' => 'CPF deve ser texto',
            'cpf.max' => 'CPF deve ter no maximo 14 caracteres',

            'phone.required' => 'Telefone é obrigatório',
            'phone.max' => 'Telefone deve ter no maximo 20 caracteres',

            'about.required' => 'Descrição é obrigatória',

            'specialties.required' => 'Especialidades são obrigatórias',
            'specialties.array' => 'Especialidades devem ser uma lista',
            'specialties.*.string' => 'Cada especialidade deve ser texto',
        ];
    }
}
