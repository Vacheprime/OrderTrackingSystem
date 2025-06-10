<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployeeSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $employeeInfo = session()->get('employee');
        if (!session()->has('employee') || !$employeeInfo["2fa_setup"]) {
            // Send a 401 error response if the content requested is json or is a refresh
            if ($request->expectsJson() || $request->hasHeader("x-refresh-table") || $request->hasHeader("x-change-details")) {
                return response()->json(['error' => 'Unauthorized', 'redirectTo' => "/"], 401);
            }

            return redirect('/');
        }

        return $next($request);
    }
}
