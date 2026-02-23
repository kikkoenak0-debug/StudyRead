<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pinjaman;
use App\Models\Favorit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->where('tersedia', '>', 0)->get();

        // Ambil peminjaman user yang sedang berlangsung
        $currentLoans = Pinjaman::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->with('buku')
            ->get() ?? collect();

        // Ambil favorit user
        $favorites = Favorit::where('user_id', Auth::id())
            ->with('buku')
            ->get() ?? collect();

        return view('home', compact('buku', 'currentLoans', 'favorites'));
    }
}
