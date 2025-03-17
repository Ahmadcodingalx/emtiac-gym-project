<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email',
            'tel' => 'required',
        ];
    }

    public function messages()
    {
        //Un peu comme les messages d'erreurs, mais pour le register

        return [
            'firstname.required' => 'Veuillez renseigner le prénom',
            'firstname.string' => 'Veuillez entrer des lettres',
            'firstname.max' => 'Le prénom ne doit pas dépasser 255 lettres',
            
            'lastname.required' => 'Veuillez renseigner le nom',
            'lastname.string' => 'Veuillez entrer des lettres',
            'lastname.max' => 'Le nom ne doit pas dépasser 255 lettres',

            'email.required' => 'Veuillez renseigner l\'email',
            'email.email' => 'L\'email est invalide',

            'tel.required' => 'Veuillez renseigner le numéro de téléphone',

            'old_password.required' => 'Veuillez entrer votre ancien mot de passe',
            'new_password.required' => 'Veuillez entrer votre nouveau mot de passe',
            'new_password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'confirm-password.same' => 'Les mot de passes ne sont pas conformes',

            // 'profil_image.image' => 'Le fichier doit être une image',
            // 'profil_image.mimes' => 'Le fichier doit être au format jpeg, png ou jpg',
            // 'profil_image.max' => 'La taille du fichier doit être inférieure à 5MB',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'success'   => false,
    //         'message'   => 'Echec de validation.',
    //         'data'      => $validator->errors()
    //     ]));
    // }
}
