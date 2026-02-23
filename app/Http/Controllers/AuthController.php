<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoggedInAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $sessionId = session()->getId();
            
            // Simpan akun yang login ke tabel logged_in_accounts
            LoggedInAccount::updateOrCreate(
                ['session_id' => $sessionId, 'user_id' => $user->id],
                ['last_active_at' => now()]
            );

            if ($user->role === 'admin') {
                return redirect('/admin')->with('success', 'Login berhasil!');
            } elseif ($user->role === 'petugas') {
                return redirect('/petugas')->with('success', 'Login berhasil!');
            }
            return redirect('/home')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Kredensial tidak valid.']);
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'user',
                'is_active' => true,
            ]);

            return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();
        
        // Hapus dari logged_in_accounts
        LoggedInAccount::where('session_id', $sessionId)
            ->where('user_id', $userId)
            ->delete();
        
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
