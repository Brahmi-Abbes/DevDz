<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $key = Str::lower($attributes['email']) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again in ' . RateLimiter::availableIn($key) . ' seconds.',
            ]);
        }

        if (! Auth::attempt($attributes)) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.',
            ]);
        }

        RateLimiter::clear($key);
        request()->session()->regenerate();
        return redirect('/');
    }


    public function destroy()
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Auth::logout();

        return redirect('/login');
    }
}
