<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\SlugHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\ClassiqueRegisterRequest;
use App\Mail\EmailVerification as MailEmailVerification;
use App\Models\EmailVerification;
use App\Models\User;
use App\Models\UserType;
use App\Models\SocialLink;
use App\Traits\VcardGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ClassiqueController extends Controller
{
    use VcardGenerator;

    /**
     * Affiche la page d'accueil
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('clients.classique.index');
    }

    /**
     * Affiche le formulaire de création
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('clients.classique.form');
    }

    /**
     * Traite l'inscription d'un nouvel utilisateur
     *
     * @param ClassiqueRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(ClassiqueRegisterRequest $request)
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
                'user_type_id' => UserType::where('name', 'classique')->first()->id,
                'is_active' => false,
                'slug' => SlugHelper::generateUniqueSlug($request->nom . ' ' . $request->prenom, $nextId),
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

            return redirect()->route('login')
                ->with('success', 'Compte créé avec succès ! Veuillez vérifier votre email.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Une erreur est survenue lors de l\'inscription : ')
                ->withInput();
        }
    }

    /**
     * Affiche le profil d'un utilisateur
     *
     * @param string $slug
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($slug)
    {
        try {
            // Recherche de l'utilisateur par son slug
            $user = User::where('slug', $slug)
                ->where('user_type_id', UserType::where('name', 'classique')->first()->id)
                ->with(['socialLinks'])
                ->firstOrFail();

            return view('clients.show.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('classique.index')
                ->with('error', 'Profil introuvable.');
        }
    }

    /**
     * Affiche le formulaire d'édition
     *
     * @param string $slug
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($slug)
    {
        try {
            $user = User::where('slug', $slug)
                ->where('user_type_id', UserType::where('name', 'classique')->first()->id)
                ->with(['socialLinks'])
                ->firstOrFail();

            return view('clients.classique.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('classique.index')
                ->with('error', 'Profil introuvable.');
        }
    }

    /**
     * Met à jour le profil d'un utilisateur
     *
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $slug)
    {
        try {
            DB::beginTransaction();

            $user = User::where('slug', $slug)
                ->where('user_type_id', UserType::where('name', 'classique')->first()->id)
                ->firstOrFail();

            // Mise à jour des informations de base
            $user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'profession' => $request->profession,
            ]);

            // Mise à jour de la photo si une nouvelle est fournie
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('profile-photos', 'public');
                $user->update(['photo_profile' => $photoPath]);
            }

            // Mise à jour des réseaux sociaux
            if ($request->has('social_links')) {
                // Supprime les anciens liens
                $user->socialLinks()->delete();

                // Ajoute les nouveaux liens
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

            // Régénération du fichier VCard
            $vcardPath = $this->generateVcard($user);
            $user->update(['vcard_file' => $vcardPath]);

            DB::commit();

            return redirect()->route('classique.show', $user->slug)
                ->with('success', 'Profil mis à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du profil : ')
                ->withInput();
        }
    }

    /**
     * Supprime un utilisateur
     *
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($slug)
    {
        try {
            DB::beginTransaction();

            $user = User::where('slug', $slug)
                ->where('user_type_id', UserType::where('name', 'classique')->first()->id)
                ->firstOrFail();

            // Suppression des liens sociaux
            $user->socialLinks()->delete();

            // Suppression de l'utilisateur
            $user->delete();

            DB::commit();

            return redirect()->route('classique.index')
                ->with('success', 'Compte supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression du compte : ');
        }
    }
}
