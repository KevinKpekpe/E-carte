<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ou auth()->check() si vous voulez vérifier l'authentification
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'telephone' => 'required|string|max:20',
            'profession' => 'required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères',
            'prenom.required' => 'Le prénom est obligatoire',
            'prenom.max' => 'Le prénom ne peut pas dépasser 255 caractères',
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

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nom' => 'nom',
            'prenom' => 'prénom',
            'email' => 'adresse email',
            'telephone' => 'numéro de téléphone',
            'profession' => 'profession',
            'photo_profile' => 'photo de profil',
        ];
    }
}
