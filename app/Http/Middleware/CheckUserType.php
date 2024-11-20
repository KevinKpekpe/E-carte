<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next, ...$userTypes)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $userType = Auth::user()->userType->name;

        if (!in_array($userType, $userTypes)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
