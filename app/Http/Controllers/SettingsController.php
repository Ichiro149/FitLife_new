<?php

/**
 * Šis kontrolieris apstrādā "Settings Controller" sadaļas pieprasījumus un lapas plūsmu.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Šī metode sagatavo un attēlo galveno lapas vai saraksta skatu.
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Šī metode apstrādā darbību "update Language" un atgriež atbilstošu rezultātu.
     */
    public function updateLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|in:en,ru,lv',
        ]);

        $language = $request->language;

        if (Auth::check()) {
            Auth::user()->update(['language' => $language]);
        }

        session(['locale' => $language]);
        App::setLocale($language);

        return back()->with('success', __('settings.language_updated'));
    }
}
