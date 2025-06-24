<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['require', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['require', 'string', 'min:6', 'confirm']
        ]);

        $user = User::create($credentials);

        if (Auth::attempt($user)) {
            $request->session()->regenerate();

            return redirect()->intended('meet');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
