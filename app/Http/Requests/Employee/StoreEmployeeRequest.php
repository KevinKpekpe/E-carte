<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:20'],
            'prenom' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'telephone' => ['required', 'string', 'max:20'],
            'profession' => ['required', 'string', 'max:255'],
            'photo_profile' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'nom.max' => 'Le nom ne peut pas dépasser 20 caractères',
            'prenom.required' => 'Le prénom est obligatoire',
            'prenom.max' => 'Le prénom ne peut pas dépasser 20 caractères',
            'email.required' => 'L\'adresse email est obligatoire',
            'email.email' => 'L\'adresse email n\'est pas valide',
            'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'telephone.required' => 'Le numéro de téléphone est obligatoire',
            'telephone.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères',
            'profession.required' => 'La profession est obligatoire',
            'profession.max' => 'La profession ne peut pas dépasser 255 caractères',
            'photo_profile.image' => 'Le fichier doit être une image',
            'photo_profile.mimes' => 'L\'image doit être de type : jpeg, png, jpg, gif',
            'photo_profile.max' => 'L\'image ne doit pas dépasser 2Mo',
        ];
    }
}
