<?php

use Illuminate\Support\Facades\Route;

/* ───────── Smart landing page ─────────
   • Guests          → /login
   • Authenticated   → /requests
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('requests.index')
        : redirect()->route('login');
});

/* ───────── Dashboard (post‑login) ─────────
   Breeze’s login controller redirects here.
   We forward users to their Requests list.
*/
Route::get('/dashboard', fn () => redirect()->route('requests.index'))
    ->middleware('auth')
    ->name('dashboard');

/* ───────── Requests CRUD ───────── */
Route::middleware('auth')->group(function () {
    Route::resource('requests', \App\Http\Controllers\RequestController::class);
});

/* ───────── Admin dashboard (RBAC) ───────── */
Route::middleware(['auth', 'role:administrator'])
    ->prefix('admin')
    ->group(function () {
        Route::view('/', 'admin.dashboard')->name('admin.dashboard');
    });

/* ───────── Breeze auth routes (login, register, password…) ───────── */
require __DIR__.'/auth.php';
