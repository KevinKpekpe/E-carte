<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class InactivityMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity');
            $timeout = config('session.lifetime') * 60;

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                session()->forget('last_activity');
                return redirect()->route('lockscreen.show');
            }
            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
