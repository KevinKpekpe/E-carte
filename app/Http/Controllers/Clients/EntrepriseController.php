<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\SlugHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\EntrepriseRegisterRequest;
use App\Http\Requests\Clients\EntrepriseUpdateRequest;
use App\Mail\EmailVerification as MailEmailVerification;
use App\Models\EmailVerification;
use App\Models\User;
use App\Models\UserType;
use App\Models\SocialLink;
use App\Models\Company;
use App\Traits\VcardGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EntrepriseController extends Controller
{
    use VcardGenerator;

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('clients.entreprise.form');
    }

    /**
     * Enregistre une nouvelle entreprise
     */
    public function register(EntrepriseRegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $nextId = DB::table('users')->max('id') + 1;

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
                'user_type_id' => UserType::where('name', 'entreprise')->first()->id,
                'is_active' => false,
                'slug' => SlugHelper::generateUniqueSlug($request->nom . ' ' . $request->prenom, $nextId),
            ]);

            // Création de l'entreprise
            Company::create([
                'user_id' => $user->id,
                'nom_entreprise' => $request->nom_entreprise,
                'nombre_employes' => $request->nombre_employes,
            ]);

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

            // Création du token de vérification
            $token = Str::random(64);
            EmailVerification::create([
                'user_id' => $user->id,
                'token' => $token,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]);

            // Envoi de l'email de vérification
            Mail::to($user->email)->send(new MailEmailVerification($user, $token));

            DB::commit();

            return redirect()->route('verification.notice')
                ->with('success', 'Compte créé avec succès ! Veuillez vérifier votre email.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Une erreur est survenue lors de l\'inscription : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit()
    {
        $user = auth()->user();
        $company = $user->company;
        return view('clients.entreprises.edit', compact('company'));
    }

    /**
     * Met à jour le profil entreprise
     */
    public function update(EntrepriseUpdateRequest $request)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();

            // Gestion de la photo
            $photoPath = $user->photo_profile;
            if ($request->hasFile('photo')) {
                if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                    Storage::disk('public')->delete($photoPath);
                }
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
            }

            // Mise à jour des informations de l'utilisateur
            $user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'profession' => $request->profession,
                'photo_profile' => $photoPath,
            ]);

            // Mise à jour des informations de l'entreprise
            $user->company()->update([
                'nom_entreprise' => $request->nom_entreprise,
                'nombre_employes' => $request->nombre_employes,
            ]);

            // Mise à jour des réseaux sociaux
            SocialLink::where('user_id', $user->id)->delete();

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

            // Mise à jour du VCard
            if ($user->vcard_file && Storage::exists($user->vcard_file)) {
                Storage::delete($user->vcard_file);
            }
            $vcardPath = $this->generateVcard($user);
            $user->update(['vcard_file' => $vcardPath]);

            DB::commit();

            return redirect()->route('entreprise.edit')
                ->with('success', 'Votre profil a été mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du profil : ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Affiche le profil d'une entreprise
     */
    public function show($slug)
    {
        try {
            $user = User::where('slug', $slug)
                ->where('user_type_id', UserType::where('name', 'entreprise')->first()->id)
                ->with(['socialLinks', 'company'])
                ->firstOrFail();

            return view('clients.entreprises.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('home')
                ->with('error', 'Profil entreprise introuvable.');
        }
    }
}
