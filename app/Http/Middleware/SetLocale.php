<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // API requests receive the selected language
        // from the frontend through Accept-Language.
        if ($request->is('api/*')) {
            $headerLocale = $request->header('Accept-Language');

            if ($headerLocale) {
                $headerLocale = strtolower(substr($headerLocale, 0, 2));
            }

            $locale = in_array($headerLocale, ['ar', 'en'], true)
                ? $headerLocale
                : session('locale', config('app.locale', 'en'));
        } else {
            // Normal web pages use the language selected by the user.
            $locale = session('locale', config('app.locale', 'en'));
        }

        if (! in_array($locale, ['ar', 'en'], true)) {
            $locale = config('app.locale', 'en');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
