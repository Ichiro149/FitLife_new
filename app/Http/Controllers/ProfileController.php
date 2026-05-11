<?php

/**
 * Šis kontrolieris apstrādā "Profile Controller" sadaļas pieprasījumus un lapas plūsmu.
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Šī metode parāda esoša ieraksta rediģēšanas formu.
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Šī metode attēlo detalizētu izvēlētā ieraksta skatu.
     */
    public function show(User $user)
    {
        $user->loadCount(['followers', 'followings', 'posts']);

        $subscriptionsCount = $user->followings_count;

        if (Schema::hasTable('subscriptions')) {
            $subscriptionsCount = $user->subscriptions()->count();
        }

        return view('profile.show', compact('user', 'subscriptionsCount'));
    }

    /**
     * Šī metode validē ievadi un atjaunina esošo ierakstu.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'age' => 'nullable|integer|min:1|max:120',
            'gender' => 'nullable|in:male,female,other',
            'height' => 'nullable|numeric|min:50|max:300',
            'weight' => 'nullable|numeric|min:20|max:500',
        ]);

        $data = $request->only('name', 'full_name', 'username', 'email', 'age', 'gender', 'height', 'weight', 'bio');

        if ($request->hasFile('banner')) {
            $this->deleteFile($user->banner);
            $data['banner'] = $request->file('banner')->store('banner', 'public');
        }

        if ($request->hasFile('avatar')) {
            $this->deleteFile($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect('/profile')->with('status', 'profile-updated');
    }

    /**
     * Šī metode apstrādā darbību "update Password" un atgriež atbilstošu rezultātu.
     */
    public function updatePassword(Request $request)
    {

        $key = 'password_update_'.Auth::id();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($key);

            return redirect()->back()->withErrors(['current_password' => "Too many attempts. Try again in {$seconds} seconds."]);
        }
        \Illuminate\Support\Facades\RateLimiter::hit($key, 60);

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->back()->with('status', 'Password updated successfully!');
    }

    /**
     * Šī metode dzēš izvēlēto ierakstu vai saturu.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Account deleted successfully!');
    }

    private function deleteFile($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
