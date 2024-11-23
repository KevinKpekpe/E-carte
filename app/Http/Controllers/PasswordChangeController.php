<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ], [
            'password.different' => 'Le nouveau mot de passe doit être différent de l\'ancien.',
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
