<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // load kategori and the user who added the book
        $buku = Buku::with(['kategori','user'])->get();
        $view = str_starts_with(request()->route()->getName(), 'admin.') ? 'admin.kelola-buku.kelola-buku' : 'petugas.kelola-buku.kelola-buku';
        return view($view, compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = \App\Models\Kategori::all();
        $view = str_starts_with(request()->route()->getName(), 'admin.') ? 'admin.kelola-buku.create' : 'petugas.kelola-buku.create';
        return view($view, compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|date',
            'isbn' => 'required|string|max:13|unique:buku',
            'kategori_id' => 'required|exists:kategori,id',
            'tersedia' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sinopsis' => 'nullable|string',
        ]);

        $data = $request->all();
        // record which user added the book
        $data['user_id'] = auth()->id();

        // Normalize tahun_terbit: accept year-only (YYYY), full date, or empty -> store as Y-m-d or null
        $tahun = $request->input('tahun_terbit');
        if ($tahun === null || $tahun === '') {
            $data['tahun_terbit'] = null;
        } else {
            if (preg_match('/^\d{4}$/', $tahun)) {
                $data['tahun_terbit'] = $tahun . '-01-01';
            } else {
                try {
                    $data['tahun_terbit'] = Carbon::parse($tahun)->format('Y-m-d');
                } catch (\Exception $e) {
                    $data['tahun_terbit'] = null;
                }
            }
        }

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('buku', 'public');
            $data['foto'] = $fotoPath;
        }

        $buku = Buku::create($data);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Buku berhasil ditambahkan']);
        }

        return redirect()->route(str_starts_with(request()->route()->getName(), 'admin.') ? 'admin.kelola-buku.index' : 'petugas.dashboard')->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = \App\Models\Kategori::all();
        $users = \App\Models\User::all();
        // determine currently assigned borrower if any
        $currentLoan = $buku->pinjaman()->where('status','approved')->latest()->first();
        $currentPeminjamId = $currentLoan ? $currentLoan->user_id : null;
        $view = str_starts_with(request()->route()->getName(), 'admin.') ? 'admin.kelola-buku.edit' : 'petugas.kelola-buku.edit';
        return view($view, compact('buku', 'kategori','users','currentPeminjamId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|date',
            'isbn' => 'required|string|max:13|unique:buku,isbn,' . $buku->id,
            'kategori_id' => 'required|exists:kategori,id',
            'tersedia' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sinopsis' => 'nullable|string',
        ]);

        $data = $request->all();

        // Normalize tahun_terbit for update as well
        $tahun = $request->input('tahun_terbit');
        if ($tahun === null || $tahun === '') {
            $data['tahun_terbit'] = null;
        } else {
            if (preg_match('/^\d{4}$/', $tahun)) {
                $data['tahun_terbit'] = $tahun . '-01-01';
            } else {
                try {
                    $data['tahun_terbit'] = Carbon::parse($tahun)->format('Y-m-d');
                } catch (\Exception $e) {
                    $data['tahun_terbit'] = null;
                }
            }
        }

        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($buku->foto && \Storage::disk('public')->exists($buku->foto)) {
                \Storage::disk('public')->delete($buku->foto);
            }
            $fotoPath = $request->file('foto')->store('buku', 'public');
            $data['foto'] = $fotoPath;
        }

        $data['user_id'] = auth()->id();
        $buku->update($data);

        return redirect()->route(str_starts_with(request()->route()->getName(), 'admin.') ? 'admin.kelola-buku.index' : 'petugas.kelola-buku.index')->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route(str_starts_with(request()->route()->getName(), 'admin.') ? 'admin.kelola-buku.index' : 'petugas.kelola-buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
