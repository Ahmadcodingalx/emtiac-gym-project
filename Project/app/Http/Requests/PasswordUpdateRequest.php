<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
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
            //
            'new_password' => 'min:8',
            'confirm-password' => 'same:new_password',
        ];
    }

    public function messages()
    {
        //Un peu comme les messages d'erreurs, mais pour le register

        return [

            'old_password.required' => 'Veuillez entrer votre ancien mot de passe',
            'new_password.required' => 'Veuillez entrer votre nouveau mot de passe',
            'new_password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'confirm-password.same' => 'Les mot de passes ne sont pas conformes',
        ];
    }
}
