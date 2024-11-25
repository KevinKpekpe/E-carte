<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    $fail('Le mot de passe actuel est incorrect.');
                }
            }],
            'password' => [
                'required',
                'confirmed',
                'different:current_password',
                Password::min(8)                    // Minimum 8 caractères
                    ->mixedCase()                    // Mélange de majuscules et minuscules
                    ->letters()                      // Au moins une lettre
                    ->numbers()                      // Au moins un chiffre
                    ->symbols()                      // Au moins un caractère spécial
                    ->uncompromised()               // Vérifie si le mot de passe n'a pas été compromis dans des fuites de données connues
            ],
        ], [
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.different' => 'Le nouveau mot de passe doit être différent de l\'ancien.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.mixed' => 'Le mot de passe doit contenir au moins une majuscule et une minuscule.',
            'password.letters' => 'Le mot de passe doit contenir au moins une lettre.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un caractère spécial.',
            'password.uncompromised' => 'Ce mot de passe a été compromis dans une fuite de données. Veuillez en choisir un autre.',
        ]);

        try {
            $user = auth()->user();
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->back()->with('success', 'Votre mot de passe a été modifié avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors du changement de mot de passe.')
                ->withInput();
        }
    }
}
