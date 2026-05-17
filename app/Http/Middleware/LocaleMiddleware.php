<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $supported = array_keys(config('languages.supported', []));

        // Priority: session > user preference > default
        if (session('locale') && in_array(session('locale'), $supported)) {
            app()->setLocale(session('locale'));
        } elseif (auth()->check() && auth()->user()->language_preference && in_array(auth()->user()->language_preference, $supported)) {
            $locale = auth()->user()->language_preference;
            session(['locale' => $locale]);
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale', 'en'));
        }

        return $next($request);
    }
}
