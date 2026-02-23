<?php

namespace App\Http\Controllers;

use App\Models\LoggedInAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Tampilkan list akun yang sedang login
     */
    public function getLoggedAccounts()
    {
        $sessionId = session()->getId();
        $accounts = LoggedInAccount::where('session_id', $sessionId)
            ->with('user')
            ->orderBy('last_active_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'accounts' => $accounts->map(function ($account) {
                return [
                    'id' => $account->user_id,
                    'name' => $account->user->name,
                    'email' => $account->user->email,
                    'role' => $account->user->role,
                    'foto' => $account->user->foto,
                    'is_active' => Auth::id() === $account->user_id,
                ];
            }),
            'current_user_id' => Auth::id(),
        ]);
    }

    /**
     * Switch ke akun lain yang sudah login
     */
    public function switchAccount($userId)
    {
        $sessionId = session()->getId();
        
        // Cek apakah user ID ada di logged_in_accounts
        $account = LoggedInAccount::where('session_id', $sessionId)
            ->where('user_id', $userId)
            ->first();

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak ditemukan dalam session ini.'
            ], 404);
        }

        // Update last_active_at
        $account->update(['last_active_at' => now()]);
        
        // Logout user saat ini dan login dengan user baru
        Auth::logout();
        Auth::loginUsingId($userId, true);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil switch akun.',
            'redirect' => $this->getRedirectPath(auth()->user()),
        ]);
    }

    /**
     * Logout dari satu akun spesifik
     */
    public function logoutAccount($userId = null)
    {
        $sessionId = session()->getId();
        $userToLogout = $userId ?? Auth::id();

        // Hapus akun dari logged_in_accounts
        LoggedInAccount::where('session_id', $sessionId)
            ->where('user_id', $userToLogout)
            ->delete();

        // Jika logout akun yang sedang aktif
        if ($userToLogout === Auth::id()) {
            Auth::logout();
            
            // Cek apakah masih ada akun lain
            $remainingAccounts = LoggedInAccount::where('session_id', $sessionId)
                ->with('user')
                ->first();

            if ($remainingAccounts) {
                // Auto-login ke akun yang tersisa
                Auth::loginUsingId($remainingAccounts->user_id, true);
                return response()->json([
                    'success' => true,
                    'message' => 'Akun dilogout, switch ke akun lain.',
                    'redirect' => $this->getRedirectPath(auth()->user()),
                ]);
            } else {
                // Tidak ada akun lain
                return response()->json([
                    'success' => true,
                    'message' => 'Logout berhasil.',
                    'redirect' => '/',
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Akun dilogout.',
        ]);
    }

    /**
     * Get redirect path berdasarkan role
     */
    private function getRedirectPath($user)
    {
        if ($user->role === 'admin') {
            return '/admin';
        } elseif ($user->role === 'petugas') {
            return '/petugas';
        }
        return '/home';
    }
}
