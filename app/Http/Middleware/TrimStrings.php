<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

/**
 * The TrimStrings middleware automatically trims request string inputs.
 * 
 * This middleware trims all string values in the request, removing whitespace from
 * the beginning and end. You can specify inputs that should not be trimmed in the
 * $except array.
 */
class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
