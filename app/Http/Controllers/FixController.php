<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class FixController extends Controller
{
    /**
     * Display a test view to verify the fixes.
     */
    public function test(Request $request)
    {
        return view('admin.dashboard');
    }
}
