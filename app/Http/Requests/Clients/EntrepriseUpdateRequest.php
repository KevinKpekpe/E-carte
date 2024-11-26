<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class EntrepriseUpdateRequest extends FormRequest
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
            'photo.max' => 'La photo ne doit pas dépasser 2Mo.',
            'photo.mimes' => 'La photo doit être au format jpeg, png, jpg ou gif.',
            'social_links.*.url' => 'L\'URL du réseau social doit être valide.',
            'nom_entreprise.required' => 'Le nom de l\'entreprise est requis.',
            'nombre_employes.required' => 'Le nombre d\'employés est requis.',
            'nombre_employes.integer' => 'Le nombre d\'employés doit être un nombre entier.',
        ];
    }
}
