<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * The EncryptCookies middleware handles cookie encryption and decryption.
 * 
 * This middleware automatically encrypts outgoing cookies and decrypts incoming cookies,
 * providing secure cookie handling for the application. You can specify cookies that
 * should not be encrypted in the $except array.
 */
class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
