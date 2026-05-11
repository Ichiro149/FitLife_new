<?php

/**
 * Šis kontrolieris apstrādā "Authenticated Session Controller" sadaļas pieprasījumus un lapas plūsmu.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    /**
     * Šī metode parāda jauna ieraksta izveides formu.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Šī metode validē ievadi un saglabā jaunu ierakstu.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Šī metode dzēš izvēlēto ierakstu vai saturu.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
