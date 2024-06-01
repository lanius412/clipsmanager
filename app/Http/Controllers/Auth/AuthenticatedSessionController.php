<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if (User::where('email', $request->email)->count() === 0) {
            return back()->withErrors([
                'login-email' => 'The email address you entered is not registered'
            ]);
        }
        
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home', absolute: false));
        }

        return back()->withErrors([
            'login-password' => 'The password you entered is incorrect',
        ])->withInput(['email' => $request->email]);
    }
}
