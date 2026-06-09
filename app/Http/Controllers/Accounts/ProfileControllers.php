<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileControllers extends Controller
{
    /**
     * Display profile edit page.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('accounts.profile', compact('user', 'profile'));
    }

    /**
     * Update profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'password' => ['nullable', 'confirmed', Password::min(6)],
        ];

        // Bidang ilmu hanya untuk pengajar
        if ($user->role === 'pengajar') {
            $rules['bidang_ilmu'] = 'nullable|string|max:255';
        }

        $request->validate($rules);

        // Update user fields
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update profile fields
        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create([
                'first_name' => null,
                'last_name' => null,
                'gambar' => null,
            ]);
        }

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($profile->gambar) {
                Storage::disk('public')->delete($profile->gambar);
            }

            $path = $request->file('gambar')->store('profiles', 'public');
            $profile->gambar = $path;
        }

        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;

        if ($user->role === 'pengajar') {
            $profile->bidang_ilmu = $request->bidang_ilmu;
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
