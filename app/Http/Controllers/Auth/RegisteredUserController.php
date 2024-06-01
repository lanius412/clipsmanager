<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } catch (ValidationException $e) {
            $validateErrors = [];
            foreach ($e->errors() as $key => $err) {
                if ($key === 'email') {
                    $validateErrors['register-email'] = $err[0];
                }
                if ($key === 'password') {
                    $validateErrors['register-password'] = $err[0];
                }
            }
            return back()->withErrors($validateErrors);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Create favorite table
        Favorite::create([
            'user_id' => $user->id,
            'ids' => [],
        ]);

        return redirect(route('home', absolute: false));
    }
}