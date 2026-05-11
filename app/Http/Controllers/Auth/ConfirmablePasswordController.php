<?php

/**
 * Šis kontrolieris apstrādā "Confirmable Password Controller" sadaļas pieprasījumus un lapas plūsmu.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{

    /**
     * Šī metode attēlo detalizētu izvēlētā ieraksta skatu.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Šī metode validē ievadi un saglabā jaunu ierakstu.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
