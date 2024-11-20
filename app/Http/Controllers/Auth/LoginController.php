<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                    return redirect()->route('client.index');
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/bye');
    }
}
