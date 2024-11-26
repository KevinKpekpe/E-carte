<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request)
    {
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
