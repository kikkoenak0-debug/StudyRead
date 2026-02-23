<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Pinjaman;
use App\Models\Ulasan;
use App\Models\Favorit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->where('tersedia', '>', 0);

        if ($request->has('kategori') && $request->kategori) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('nama', $request->kategori);
            });
        }

        $buku = $query->get();
        $kategori = \App\Models\Kategori::pluck('nama');
        $bukuGrouped = $buku->groupBy(function($item) {
            return $item->kategori->nama ?? '';
        });
        return view('buku', compact('buku', 'kategori', 'bukuGrouped'));
    }

    public function show($id)
    {
        $buku = Buku::with('user')->findOrFail($id);
        
        // Ambil ulasan buku
        $ulasan = Ulasan::where('buku_id', $id)->with('user')->latest()->get();
        
        // Hitung rating rata-rata
        $ratingRataRata = Ulasan::where('buku_id', $id)->avg('rating');
        $totalUlasan = $ulasan->count();
        
        // Cek apakah buku sudah difavoritkan user
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Favorit::where('user_id', Auth::id())
                ->where('buku_id', $id)
                ->exists();
        }
        
        return view('buku-detail', compact('buku', 'ulasan', 'ratingRataRata', 'totalUlasan', 'isFavorited'));
    }

    public function pinjamLangsung($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->tersedia <= 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia.');
        }

        // Buat pinjaman dengan status pending
        Pinjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'status' => 'pending',
        ]);

        return redirect()->route('riwayat.pinjaman')->with('success', 'Permintaan peminjaman telah dikirim. Tunggu konfirmasi dari petugas.');
    }

    public function create()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('buku.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:buku',
            'tahun_terbit' => 'nullable|date',
            'kategori' => 'required|string|max:255',
            'tersedia' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        // Normalize tahun_terbit before create
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

        Buku::create($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Buku $buku)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:buku,isbn,' . $buku->id,
            'tahun_terbit' => 'nullable|date',
            'kategori' => 'required|string|max:255',
            'tersedia' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        // Normalize tahun_terbit before update
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

        $buku->update($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Buku $buku)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }

    public function halamanPinjam($id)
    {
        $buku = Buku::find($id);
        
        if (!$buku) {
            return redirect('/buku')->with('error', 'Buku tidak ditemukan.');
        }
        
        return view('pinjam', compact('buku'));
    }

    public function pinjam(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:buku,id',
            'nama_lengkap' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'tanggal_kembali' => 'required|date|after:today',
        ]);

        try {
            // Buat peminjaman baru dengan status pending
            $pinjaman = Pinjaman::create([
                'user_id' => Auth::id(),
                'buku_id' => $request->book_id,
                'tanggal_pinjam' => now(),
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'pending',
            ]);

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Peminjaman berhasil diajukan. Tunggu konfirmasi dari petugas.']);
            }

            return redirect()->route('riwayat.pinjaman')->with('success', 'Peminjaman berhasil diajukan. Tunggu konfirmasi dari petugas.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
            return redirect('/riwayat-pinjaman')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function toggleFavorit($id)
    {
        $buku = Buku::findOrFail($id);
        $userId = Auth::id();

        $favorit = Favorit::where('user_id', $userId)->where('buku_id', $id)->first();

        if ($favorit) {
            $favorit->delete();
            return response()->json(['success' => true, 'message' => 'Dihapus dari favorit', 'isFavorited' => false]);
        } else {
            Favorit::create([
                'user_id' => $userId,
                'buku_id' => $id,
            ]);
            return response()->json(['success' => true, 'message' => 'Ditambahkan ke favorit', 'isFavorited' => true]);
        }
    }

    public function simpanUlasan(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'ulasan' => 'required|string|min:10',
        ]);

        $buku = Buku::findOrFail($id);
        
        $ulasanLama = Ulasan::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->first();

        if ($ulasanLama) {
            $ulasanLama->update([
                'rating' => $request->rating,
                'ulasan' => $request->ulasan,
            ]);
        } else {
            Ulasan::create([
                'user_id' => Auth::id(),
                'buku_id' => $id,
                'rating' => $request->rating,
                'ulasan' => $request->ulasan,
            ]);
        }

        return redirect()->route('buku.show', $id)->with('success', 'Ulasan berhasil disimpan');
    }
}