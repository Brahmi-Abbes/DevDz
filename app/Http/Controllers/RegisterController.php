<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\File;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'name'  => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],        ]);

        $user = User::create($userAttributes);

        Auth::login($user);

        return redirect('/');
    }
}
