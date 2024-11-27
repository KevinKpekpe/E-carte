<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification as MailEmailVerification;
use App\Models\EmailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class VerifyController extends Controller
{
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
        $user->update([
            'email_verified_at' => Carbon::now(),
            'is_active' => true,
            'expiration_date' => now()
        ]);
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
        EmailVerification::where('user_id', $user->id)->delete();

        $token = Str::random(64);
        EmailVerification::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => Carbon::now()->addMinutes(10)
        ]);
        Mail::to($user->email)->send(new MailEmailVerification($user, $token));

        return back()->with('success', 'Un nouveau lien de vérification a été envoyé à votre adresse email.');
    }
}
