<?php

/**
 * Šis kontrolieris apstrādā "Progress Photo Controller" sadaļas pieprasījumus un lapas plūsmu.
 */

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgressPhotoController extends Controller
{

    /**
     * Šī metode sagatavo un attēlo galveno lapas vai saraksta skatu.
     */
    public function index()
    {
        $progressPhotos = Auth::user()->progress()->latest()->get();

        return view('progress.index', compact('progressPhotos'));
    }

    /**
     * Šī metode validē ievadi un saglabā jaunu ierakstu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        Auth::user()->progress()->create([
            'photo' => $request->file('photo')->store('progress', 'public'),
            'description' => $request->description,
        ]);

        return back()->with('success', '');
    }

    /**
     * Šī metode validē ievadi un atjaunina esošo ierakstu.
     */
    public function update(Request $request, Progress $progress)
    {
        $this->authorizeUser($progress);

        $request->validate([
            'description' => 'nullable|string|max:255',
        ]);

        $progress->update(['description' => $request->description]);

        return back()->with('success', '');
    }

    /**
     * Šī metode dzēš izvēlēto ierakstu vai saturu.
     */
    public function destroy(Progress $progress)
    {
        $this->authorizeUser($progress);

        Storage::disk('public')->delete($progress->photo);
        $progress->delete();

        return back()->with('success', '');
    }

    private function authorizeUser(Progress $progress)
    {
        if ($progress->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
