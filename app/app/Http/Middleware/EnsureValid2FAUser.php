<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureValid2FAUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $previousPath = parse_url(url()->previous(), PHP_URL_PATH);

        if ($previousPath === '/qr2fa') {
            if (!session()->has('employee')) {
                return redirect('/');
            }
        } else {
            if (!session()->has('user_requesting_new_password')) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
