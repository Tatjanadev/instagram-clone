<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the selected locale from the session.
        // If no locale has been selected yet, use the application's default locale.
        $locale = $request->session()->get('locale', config('app.locale'));

        // Tell Laravel to use this locale for the current request.
        app()->setLocale($locale);

        // Continue processing the request after the locale has been set.
        return $next($request);
    }
}
