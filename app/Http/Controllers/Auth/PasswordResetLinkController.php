<?php

/**
 * Šis kontrolieris apstrādā "Password Reset Link Controller" sadaļas pieprasījumus un lapas plūsmu.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{

    /**
     * Šī metode parāda jauna ieraksta izveides formu.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Šī metode validē ievadi un saglabā jaunu ierakstu.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->string('email'))->first();

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __(Password::INVALID_USER)]);
        }

        $token = Password::broker()->createToken($user);

        return back()->with([
            'status' => __('auth.reset_link_ready'),
            'reset_link' => route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]),
        ]);
    }
}
