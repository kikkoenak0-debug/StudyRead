<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class KelolaBukuController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::all();
        if ($request->wantsJson()) {
            return response()->json($buku);
        }
        return view('admin.kelola-buku.index', compact('buku'));
    }

    public function create()
    {
        return view('admin.kelola-buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:kelola_buku',
            'kategori' => 'required|string|max:255',
            'tersedia' => 'required|integer|min:0',
        ]);

        $buku = Buku::create($request->all());

        if ($request->wantsJson()) {
            return response()->json($buku, 201);
        }
        return redirect()->route('kelola-buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Request $request, Buku $kelolaBuku)
    {
        if ($request->wantsJson()) {
            return response()->json($kelolaBuku);
        }
        return view('admin.kelola-buku.show', compact('kelolaBuku'));
    }

    public function edit(Buku $kelolaBuku)
    {
        return view('admin.kelola-buku.edit', compact('kelolaBuku'));
    }

    public function update(Request $request, Buku $kelolaBuku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:buku,isbn,' . $kelolaBuku->id,
            'kategori' => 'required|string|max:255',
            'tersedia' => 'required|integer|min:0',
        ]);

        $kelolaBuku->update($request->all());

        if ($request->wantsJson()) {
            return response()->json($kelolaBuku);
        }
        return redirect()->route('kelola-buku.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Request $request, Buku $kelolaBuku)
    {
        $kelolaBuku->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Buku berhasil dihapus']);
        }
        return redirect()->route('kelola-buku.index')->with('success', 'Buku berhasil dihapus');
    }
}