<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'bidang_ilmu' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = $user->profile;

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
        $profile->bidang_ilmu = $request->bidang_ilmu;
        $profile->save();

        // Update user name jika first_name diisi
        if ($request->first_name) {
            $user->name = trim($request->first_name . ' ' . $request->last_name);
            $user->save();
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
