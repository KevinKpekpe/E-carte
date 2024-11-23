<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Affiche le formulaire de réinitialisation du mot de passe
     */
    public function showForgotPasswordForm()
    {
        return view('auth.recovery-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            // Debug: Afficher que nous avons reçu la requête
            Log::info('Demande de réinitialisation reçue pour: ' . $request->email);

            // Trouver l'utilisateur
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                Log::error('Utilisateur non trouvé');
                return back()->withErrors(['email' => 'Utilisateur non trouvé']);
            }

            // Générer un token
            $token = Str::random(64);

            // Enregistrer le token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

            Log::info('Email envoyé à: ' . $request->email);

            return back()->with('status', 'Si votre email existe dans notre système, vous recevrez un lien de réinitialisation.');
        } catch (\Exception $e) {
            Log::error('Erreur: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Une erreur est survenue: ' . $e->getMessage()]);
        }
    }
    /**
     * Affiche le formulaire de réinitialisation du mot de passe
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Réinitialise le mot de passe
     */
    public function resetPassword(Request $request)
    {
        // Validation
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'L\'adresse email est requise',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'email.exists' => 'Cette adresse email n\'existe pas dans notre système',
            'password.required' => 'Le mot de passe est requis',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas'
        ]);

        try {
            // Vérifier le token
            $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();

            if (!$tokenData) {
                return back()->withErrors(['email' => 'Token invalide ou expiré']);
            }

            // Vérifier si le token n'a pas expiré (24h par exemple)
            $tokenCreated = Carbon::parse($tokenData->created_at);
            if (Carbon::now()->diffInHours($tokenCreated) > 24) {
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
                return back()->withErrors(['email' => 'Le token a expiré']);
            }

            // Mettre à jour le mot de passe
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            // Supprimer le token
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé avec succès !');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Une erreur est survenue lors de la réinitialisation du mot de passe.']);
        }
    }
}
