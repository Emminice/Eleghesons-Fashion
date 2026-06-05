<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Redirect admins to admin dashboard, customers to their dashboard
                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('customer.dashboard');
            }
        }

        return $next($request);
    }
}
