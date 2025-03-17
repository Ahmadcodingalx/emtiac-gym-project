<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ];
    }

    public function messages()
    {
        //Un peu comme les messages d'erreurs, mais pour le register

        return [
            'name.required' => 'Veuillez renseigner le nom du produit',
            'price.required' => 'Veuillez renseigner le prix du produit',
            'quantity.required' => 'Veuillez renseigner le quantité du produit',
            
        ];
    }
}
