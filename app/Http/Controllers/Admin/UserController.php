<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivationMail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['userType', 'company', 'socialLinks'])
            ->where('user_type_id', '!=', 1);

        // Gestion du tri
        switch ($request->sort) {
            case '1': // Tri par nom
                $query->orderBy('nom');
                break;
            case '2': // Tri par type
                $query->orderBy('user_type_id');
                break;
            default:
                $query->latest();
                break;
        }

        // Gestion de la recherche
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhereHas('company', function ($q) use ($search) {
                        $q->where('nom_entreprise', 'LIKE', "%{$search}%");
                    });
            });
        }

        $users = $query->get();

        return view('admin.users.index', compact('users'));
    }

    public function deactivateAccount($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update([
                'is_active' => false
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Le compte a été désactivé avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Erreur lors de la désactivation du compte');
        }
    }

    public function sendActivationLink($id)
    {
        try {
            $user = User::findOrFail($id);
            $token = Str::random(60);

            // Stocker le token dans la base de données
            $user->update([
                'activation_token' => $token
            ]);

            // Envoyer l'email d'activation
            Mail::to($user->email)->send(new AccountActivationMail($user, $token));

            return redirect()->route('admin.users.index')
                ->with('success', "Le lien d'activation a été envoyé avec succès");
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', "Erreur lors de l'envoi du lien d'activation");
        }
    }

    public function activateAccount($token)
    {
        try {
            $user = User::where('activation_token', $token)->first();

            if (!$user) {
                return redirect()->route('login')
                    ->with('error', 'Token d\'activation invalide');
            }

            $user->update([
                'is_active' => true,
                'activation_token' => null,
                'expiration_date'=> now(),
            ]);

            return redirect()->route('login')
                ->with('success', 'Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Erreur lors de l\'activation du compte: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'Le compte a été supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Erreur lors de la suppression du compte');
        }
    }
}
