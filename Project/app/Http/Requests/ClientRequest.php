<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'tel' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        //Un peu comme les messages d'erreurs, mais pour le register

        return [
            'firstname.required' => 'Veuillez entrer le prénom',
            'firstname.string' => 'Veuillez entrer des lettres',
            'firstname.max' => 'Le prénom ne doit pas dépasser 255 lettres',
            
            'lastname.required' => 'Veuillez renseigner le nom',
            'lastname.string' => 'Veuillez entrer des lettres',
            'lastname.max' => 'Le nom ne doit pas dépasser 255 lettres',

            // 'email.required' => 'Veuillez renseigner l\'email',
            // 'email.email' => 'L\'email est invalide',

            'tel.required' => 'Veuillez renseigner le numéro de téléphone',

            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'Le fichier doit être au format jpeg, png ou jpg',
            'image.max' => 'La taille du fichier doit être inférieure à 2MB',
        ];
    }
}
