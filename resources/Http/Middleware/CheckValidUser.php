<?php
/**
 * This file is part of the AmphiBee package.
 * (c) AmphiBee <contact@amhibee.fr>
 */

namespace Amphibee\Plugin\FrontendAccount\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Themosis\Support\Facades\User;

class CheckValidUser extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next, ...$guards): mixed
    {
        $currentUser = User::current();

        if (! $currentUser || ! is_user_logged_in()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
