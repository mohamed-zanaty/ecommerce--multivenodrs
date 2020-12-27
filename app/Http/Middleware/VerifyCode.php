<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyCode
{

    public function handle($request, Closure $next)
    {
        if (Auth::guard()->check()) {  // if he already registered and have account

            if(Auth::user() -> email_verified_at == null){

                return redirect(RouteServiceProvider::VERIFIED);

            }

        }
        return $next($request);
    }
}
