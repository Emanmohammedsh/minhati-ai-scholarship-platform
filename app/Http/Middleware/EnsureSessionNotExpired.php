<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSessionNotExpired
{
    private const INACTIVITY_MINUTES = 30;

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user) {
            $token = $user->currentAccessToken();

            if ($token && $token->last_used_at
                && $token->last_used_at->diffInMinutes(now()) > self::INACTIVITY_MINUTES) {
                $token->delete();

                return response()->json([
                    'message' => 'Your session has expired due to inactivity. Please log in again.',
                ], 401);
            }
        }

        return $next($request);
    }
}
