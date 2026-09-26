<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        /*
         * API requests can send the current UI language
         * through the Accept-Language header.
         */
        $headerLocale = $request->header('Accept-Language');

        if ($headerLocale) {
            $headerLocale = strtolower(
                substr($headerLocale, 0, 2)
            );
        }

        /*
         * Prefer the language sent by the current page.
         * Otherwise use the language stored in the session.
         */
        $locale = in_array($headerLocale, ['ar', 'en'], true)
            ? $headerLocale
            : session('locale', config('app.locale'));

        if (! in_array($locale, ['ar', 'en'], true)) {
            $locale = config('app.locale', 'en');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
