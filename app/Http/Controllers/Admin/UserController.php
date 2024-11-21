<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivationMail;
use App\Models\Company;
use App\Models\SocialLink;
use App\Traits\VcardGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use VcardGenerator;
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

        $users = $query->paginate(6);

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

    public function store(Request $request)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'required|string|max:20',
            'profession' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_type_id' => 'required|exists:user_types,id',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required|string|max:255',
            'social_links.*.url' => 'required|url',
        ];

        // Validation supplémentaire pour entreprise
        if ($request->user_type_id == 4) {
            $rules['nom_entreprise'] = 'required|string|max:255';
            $rules['nombre_employes'] = 'required|integer|min:1';
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            // Traitement de la photo
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
            }

            // Création de l'utilisateur
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telephone' => $request->telephone,
                'profession' => $request->profession,
                'photo_profile' => $photoPath,
                'user_type_id' => $request->user_type_id,
                'is_active' => true,
                'expiration_date' => now(),
            ]);

            // Création de l'entreprise si nécessaire
            if ($request->user_type_id == 4) {
                Company::create([
                    'user_id' => $user->id,
                    'nom_entreprise' => $request->nom_entreprise,
                    'nombre_employes' => $request->nombre_employes,
                ]);
            }

            // Enregistrement des réseaux sociaux
            if ($request->has('social_links')) {
                foreach ($request->social_links as $link) {
                    if (!empty($link['platform']) && !empty($link['url'])) {
                        SocialLink::create([
                            'user_id' => $user->id,
                            'platform' => $link['platform'],
                            'url' => $link['url'],
                        ]);
                    }
                }
            }

            // Génération du fichier VCard
            $vcardPath = $this->generateVcard($user);
            $user->update(['vcard_file' => $vcardPath]);

            DB::commit();

            return redirect()->route('admin.users.index')
            ->with('success', 'Le compte a été créé avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')
            ->with('error', 'Erreur lors de la création du compte');
        }
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|string|max:20',
            'profession' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_type_id' => 'required|exists:user_types,id',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required|string|max:255',
            'social_links.*.url' => 'required|url',
        ];

        // Validation supplémentaire pour entreprise
        if ($request->user_type_id == 4) {
            $rules['nom_entreprise'] = 'required|string|max:255';
            $rules['nombre_employes'] = 'required|integer|min:1';
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            // Mise à jour de la photo si nécessaire
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($user->photo_profile) {
                    Storage::disk('public')->delete($user->photo_profile);
                }
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
                $user->photo_profile = $photoPath;
            }

            // Mise à jour des informations de l'utilisateur
            $user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'profession' => $request->profession,
                'user_type_id' => $request->user_type_id,
            ]);

            // Gestion de l'entreprise
            if ($request->user_type_id == 4) {
                $user->company()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nom_entreprise' => $request->nom_entreprise,
                        'nombre_employes' => $request->nombre_employes,
                    ]
                );
            } else {
                // Supprimer les informations d'entreprise si l'utilisateur n'est plus une entreprise
                $user->company()->delete();
            }

            // Mise à jour des réseaux sociaux
            // D'abord, supprimer tous les liens existants
            $user->socialLinks()->delete();

            // Puis ajouter les nouveaux liens
            if ($request->has('social_links')) {
                foreach ($request->social_links as $link) {
                    if (!empty($link['platform']) && !empty($link['url'])) {
                        SocialLink::create([
                            'user_id' => $user->id,
                            'platform' => $link['platform'],
                            'url' => $link['url'],
                        ]);
                    }
                }
            }

            // Régénérer le VCard
            $vcardPath = $this->generateVcard($user);
            $user->update(['vcard_file' => $vcardPath]);

            DB::commit();

            return redirect()->route('admin.users.index')
            ->with('success', 'Le compte a été mise à jour avec succès');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')
            ->with('error', 'Erreur lors de la mise à jour du compte');
        }
    }
}
