<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
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
    public function index(){
        return view('clients.classique.index');
    }
    public function create(){
        return view('clients.classique.form');
    }
    use VcardGenerator;

    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'required|string|max:20',
            'profession' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required|string|max:255',
            'social_links.*.url' => 'required|url',
        ]);

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
                'user_type_id' => UserType::where('name', 'classique')->first()->id,
                'is_active' => false,
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
            return back()->with('error', 'Une erreur est survenue lors de l\'inscription.' . $e)
                ->withInput();
        }
    }
    public function verifyEmail($token)
    {
        $verification = EmailVerification::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$verification) {
            return redirect()->route('login')
            ->with('error', 'Le lien de vérification est invalide ou a expiré.');
        }

        $user = $verification->user;
        $user->update(['email_verified_at' => Carbon::now()]);
        $verification->delete();

        return redirect()->route('login')
        ->with('success', 'Votre compte a été vérifié avec succès ! Vous pouvez maintenant vous connecter.');
    }
    public function resendVerification(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Utilisateur non trouvé.');
        }

        if ($user->email_verified_at) {
            return back()->with('info', 'Cet email est déjà vérifié.');
        }

        // Supprimer l'ancien token s'il existe
        EmailVerification::where('user_id', $user->id)->delete();

        // Créer un nouveau token
        $token = Str::random(64);
        EmailVerification::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // Renvoyer l'email
        Mail::to($user->email)->send(new MailEmailVerification($user, $token));

        return back()->with('success', 'Un nouveau lien de vérification a été envoyé à votre adresse email.');
    }
}
