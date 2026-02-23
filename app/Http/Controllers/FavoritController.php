<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    public function index()
    {
        $favorites = Favorit::where('user_id', Auth::id())
            ->with('buku')
            ->get();

        return view('favorit', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $userId = Auth::id();
        $bukuId = $request->buku_id;

        $favorit = Favorit::where('user_id', $userId)
            ->where('buku_id', $bukuId)
            ->first();

        if ($favorit) {
            $favorit->delete();
            return response()->json(['status' => 'removed']);
        } else {
            Favorit::create([
                'user_id' => $userId,
                'buku_id' => $bukuId,
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}