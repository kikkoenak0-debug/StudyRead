<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Pinjaman;

class ProfileController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::with('buku')->where('user_id', auth()->id())->get();
        return view('profil', compact('pinjaman'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => ['required_with:password', 'current_password'],
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            // Double-check current password to provide a clear error message if mismatch
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok'])->withInput();
            }

            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }
            // Simpan foto baru
            $path = $request->file('foto')->store('profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
