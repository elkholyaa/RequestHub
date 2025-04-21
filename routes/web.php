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
   Breeze's login controller redirects here.
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
Route::middleware('auth')
    ->middleware('role:administrator')
    ->prefix('admin')
    ->group(function () {
        Route::view('/', 'admin.dashboard')->name('admin.dashboard');
    });

/* ───────── Debug route to test request form submission ───────── */
Route::get('/debug-request-form', function () {
    return view('requests.debug');
})->middleware('auth')->name('debug.request.form');

Route::post('/debug-request-store', function (\Illuminate\Http\Request $request) {
    return [
        'success' => true,
        'data' => $request->all()
    ];
})->middleware('auth')->name('debug.request.store');

/* ───────── Test route to verify our fixes ───────── */
Route::get('/test-fix', [\App\Http\Controllers\FixController::class, 'test'])
    ->name('test.fix');

/* ───────── Breeze auth routes (login, register, password…) ───────── */
require __DIR__.'/auth.php';
