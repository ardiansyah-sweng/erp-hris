<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'profile_photo.image' => 'File harus berupa gambar.',
                'profile_photo.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
                'profile_photo.max' => 'Ukuran foto maksimal 2 MB.',
            ]
        );

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {

            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $photo = $request->file('profile_photo')
                ->store('profile_photos', 'public');

            $user->profile_photo = $photo;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroyPhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo) {

            Storage::disk('public')->delete($user->profile_photo);

            $user->profile_photo = null;

            $user->save();
        }

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }
}