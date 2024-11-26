<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class EntrepriseRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'telephone' => ['required', 'string', 'max:20'],
            'profession' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'nom_entreprise' => ['required', 'string', 'max:255'],
            'nombre_employes' => ['required', 'integer'],
            'social_links' => ['nullable', 'array'],
            'social_links.*.platform' => ['required', 'string', 'max:255'],
            'social_links.*.url' => ['required', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'photo.max' => 'La photo ne doit pas dépasser 2Mo.',
            'photo.mimes' => 'La photo doit être au format jpeg, png, jpg ou gif.',
            'social_links.*.url' => 'L\'URL du réseau social doit être valide.',
            'nom_entreprise.required' => 'Le nom de l\'entreprise est requis.',
            'nombre_employes.required' => 'Le nombre d\'employés est requis.',
            'nombre_employes.integer' => 'Le nombre d\'employés doit être un nombre entier.',
        ];
    }
}
