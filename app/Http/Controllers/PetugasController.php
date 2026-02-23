<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Pinjaman;
use App\Models\Laporan;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $peminjamanAktif = Pinjaman::whereIn('status', ['paid', 'approved'])->count();
        $loansToConfirm = Pinjaman::with(['user', 'buku'])->where('status', 'pending')->get();
        $allLoans = Pinjaman::with(['user', 'buku'])->latest()->paginate(10);

        return view('petugas.dashboard', compact('totalBuku', 'peminjamanAktif', 'loansToConfirm', 'allLoans'));
    }

    public function konfirmasi(Request $request, Pinjaman $pinjaman)
    {
        $action = $request->input('action');
        $message = 'Aksi tidak valid.';
        $success = false;
        
        if ($action === 'approve') {
            if ($pinjaman->status === 'pending') {
                $pinjaman->status = 'approved';
                $message = 'Peminjaman telah dikonfirmasi. Peminjaman aktif.';
                $success = true;
                
                // Kurangi stok buku
                $buku = $pinjaman->buku;
                if ($buku->tersedia > 0) {
                    $buku->tersedia -= 1;
                    $buku->save();
                } else {
                    return response()->json(['success' => false, 'message' => 'Stok buku tidak tersedia.'], 400);
                }
            }
        } elseif ($action === 'reject') {
            $pinjaman->status = 'rejected';
            $message = 'Peminjaman telah ditolak.';
            $success = true;
        }
        
        $pinjaman->save();
        
        // Check if it's an AJAX request
        if ($request->expectsJson()) {
            return response()->json(['success' => $success, 'message' => $message]);
        }
        
        return redirect()->route('petugas.dashboard')->with('success', $message);
    }

    public function catatPengembalian(Request $request, Pinjaman $pinjaman)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'kondisi_buku' => 'required|in:baik,rusak,hilang',
            'denda' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Ciptakan laporan pengembalian
        $laporan = Laporan::create([
            'pinjaman_id' => $pinjaman->id,
            'user_id' => $pinjaman->user_id,
            'buku_id' => $pinjaman->buku_id,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'kondisi_buku' => $request->kondisi_buku,
            'denda' => $request->denda ?? 0,
            'keterangan' => $request->keterangan,
        ]);

        // Update status pinjaman menjadi returned
        $pinjaman->status = 'returned';
        $pinjaman->save();

        // Kembalikan stok buku
        $buku = $pinjaman->buku;
        $buku->tersedia += 1;
        $buku->save();

        return redirect()->route('petugas.dashboard')->with('success', 'Laporan pengembalian buku telah dicatat.');
    }

    public function laporan()
    {
        $laporanPengembalian = Laporan::with(['user', 'buku'])->latest()->paginate(10);
        
        return view('petugas.laporan', compact('laporanPengembalian'));
    }

    public function ubahDenda(Request $request, Laporan $laporan)
    {
        $request->validate([
            'denda' => 'required|integer|min:0',
        ]);

        $laporan->update([
            'denda' => $request->denda,
        ]);

        return redirect()->route('petugas.laporan')->with('success', 'Denda telah diperbarui.');
    }

    public function destroyPinjaman(Request $request, Pinjaman $pinjaman)
    {
        // Kembalikan stok buku jika status buku sudah dikurangi
        if (in_array($pinjaman->status, ['approved', 'paid'])) {
            $buku = $pinjaman->buku;
            $buku->tersedia += 1;
            $buku->save();
        }

        // Hapus laporan yang berkaitan jika ada
        Laporan::where('pinjaman_id', $pinjaman->id)->delete();

        // Hapus pinjaman
        $pinjaman->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data peminjaman telah dihapus.'
            ]);
        }

        return redirect()->route('petugas.dashboard')->with('success', 'Data peminjaman telah dihapus.');
    }
}
