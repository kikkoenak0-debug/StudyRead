<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama')->paginate(20);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama',
        ]);

        Kategori::create($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dibuat. Anda sekarang bisa menggunakannya di Kelola Buku!');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $kategori->id,
        ]);

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->bukus()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori mempunyai buku. Pindahkan atau hapus buku terlebih dahulu.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
