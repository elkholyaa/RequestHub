<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * The VerifyCsrfToken middleware verifies that CSRF tokens match.
 * 
 * This middleware protects your application from cross-site request forgery (CSRF) attacks
 * by verifying that the authenticated user is the one actually making the requests.
 * Routes that should be excluded from CSRF verification can be specified in the $except array.
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
