<?php

namespace App\Http\Middleware;

use App\Models\EmailCodes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificationEmail
{

    private function logoutCode(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) { 
            return redirect('/');
        }
        $userId = $request->user()->id;
        $authCode = EmailCodes::where('user_id', $userId)->first();
        if (!$authCode) {
            return $this->logoutCode($request);
        }
        if (!$authCode->confirm) {
            return $this->logoutCode($request);
        }
        return $next($request);
    }
}
