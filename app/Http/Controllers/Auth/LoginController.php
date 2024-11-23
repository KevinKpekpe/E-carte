<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirection selon le type d'utilisateur
            $userType = Auth::user()->userType->name;

            switch ($userType) {
                case 'superadmin':
                    return redirect()->route('admin.dashboard');
                case 'classique':
                    return redirect()->route('classique.index');
                case 'premium':
                    return redirect()->route('premium.index');
                case 'entreprise':
                    return redirect()->route('entreprise.index');
                default:
                    return redirect('/');
            }
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    // Affiche l'écran de verrouillage
    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('auth.lockscreen');
    }
    public function unlock(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (Hash::check($request->password, $user->password)) {
            session(['last_activity' => time()]);
            return redirect()->intended('/admin')->with('message', 'Session réactivée.');
        }

        return redirect()->route('lockscreen.show')->withErrors([
            'password' => 'Mot de passe incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/bye');
    }
}
