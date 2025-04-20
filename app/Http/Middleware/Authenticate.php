<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * The Authenticate middleware handles authentication verification.
 * 
 * This middleware verifies that a user is authenticated. If they are not,
 * they will be redirected to the login page. The middleware can be applied
 * to routes that require authentication.
 */
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
