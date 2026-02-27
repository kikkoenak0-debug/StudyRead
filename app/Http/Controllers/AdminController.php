<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Pinjaman;
use App\Models\Laporan;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalUsers = User::count();
        $peminjamanAktif = \App\Models\Pinjaman::whereIn('status', ['approved_pending_payment', 'approved'])->count();

        $activeLoans = \App\Models\Pinjaman::with(['user', 'buku'])->whereIn('status', ['approved_pending_payment', 'approved'])->latest()->paginate(10);
        $transactionHistory = \App\Models\Pinjaman::with(['user', 'buku'])->whereIn('status', ['approved', 'returned', 'rejected'])->latest()->paginate(10);
        $loansToConfirm = \App\Models\Pinjaman::with(['user', 'buku'])->where('status', 'pending')->get();

        return view('admin.dashboard', compact('totalBuku', 'totalUsers', 'peminjamanAktif', 'activeLoans', 'transactionHistory', 'loansToConfirm'));
    }

    public function kelolaPengguna()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.kelola-pengguna', compact('users'));
    }

    public function createPengguna()
    {
        return view('admin.kelola-pengguna.create');
    }

    public function storePengguna(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petugas,user',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ];

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/fotos');
            $data['foto'] = basename($path);
        }

        User::create($data);

        return redirect()->route('admin.kelola-pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function editPengguna(User $user)
    {
        return view('admin.kelola-pengguna.edit', compact('user'));
    }

    public function updatePengguna(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,petugas,user',
            'is_active' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'is_active']));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/fotos');
            $user->foto = basename($path);
            $user->save();
        }

        return redirect()->route('admin.kelola-pengguna.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroyPengguna(User $user)
    {
        $user->delete();
        return redirect()->route('admin.kelola-pengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->route('admin.kelola-pengguna.index')->with('success', 'Status pengguna berhasil diubah');
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
        
        return redirect()->route('admin.dashboard')->with('success', $message);
    }

    public function laporan()
    {
        $laporanPengembalian = Laporan::with(['user', 'buku'])->latest()->paginate(10);
        $transactionHistory = \App\Models\Pinjaman::with(['user', 'buku'])
            ->whereIn('status', ['paid', 'approved', 'returned'])
            ->latest()
            ->paginate(20);
        
        return view('admin.laporan', compact('laporanPengembalian', 'transactionHistory'));
    }

    public function ulasan()
    {
        $ulasanList = Ulasan::with(['user', 'buku'])->latest()->paginate(10);
        
        return view('admin.ulasan', compact('ulasanList'));
    }

    public function updateUlasan(Request $request, Ulasan $ulasan)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string',
        ]);

        $ulasan->update([
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Ulasan berhasil diperbarui.']);
        }

        return redirect()->route('admin.ulasan')->with('success', 'Ulasan berhasil diperbarui.');
    }

    public function deleteUlasan(Ulasan $ulasan)
    {
        $ulasan->delete();

        return redirect()->route('admin.ulasan')->with('success', 'Ulasan berhasil dihapus.');
    }

    public function kelolaPetugas()
    {
        $petugas = User::whereIn('role', ['petugas', 'admin'])->get();
        return view('admin.kelola-petugas', compact('petugas'));
    }

    /**
     * Show form to create a new petugas/admin account.
     */
    public function createPetugas()
    {
        return view('admin.kelola-petugas.create');
    }

    /**
     * Store a new petugas or admin user.
     */
    public function storePetugas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petugas',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ];

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/fotos');
            $data['foto'] = basename($path);
        }

        User::create($data);

        return redirect()->route('admin.kelola-petugas.index')->with('success', 'Petugas berhasil ditambahkan');
    }

    public function toggleStatusPetugas(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
        return redirect()->route('admin.kelola-petugas.index')->with('success', 'Status petugas berhasil diubah');
    }
}
