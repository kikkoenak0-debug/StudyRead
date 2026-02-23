
<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBukuController;
use App\Http\Controllers\PetugasBukuController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\FavoritController;
use Illuminate\Support\Facades\Auth;
use App\Models\Pinjaman;
use App\Models\Laporan;

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::view('/register', 'register')->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::get('/favorit', [FavoritController::class, 'index'])->middleware('auth')->name('favorit.index');
Route::post('/favorit/toggle', [FavoritController::class, 'toggle'])->middleware('auth')->name('favorit.toggle');

Route::post('/logout', [AuthController::class, 'logout']);

// Multi-account routes
Route::middleware('auth')->group(function () {
    Route::get('/api/accounts', [AccountController::class, 'getLoggedAccounts'])->name('accounts.list');
    Route::post('/account/switch/{userId}', [AccountController::class, 'switchAccount'])->name('account.switch');
    Route::post('/account/logout/{userId?}', [AccountController::class, 'logoutAccount'])->name('account.logout');
});

Route::get('/admin', [AdminController::class, 'index'])->middleware('admin')->name('admin.dashboard');

Route::patch('/admin/konfirmasi/{pinjaman}', [AdminController::class, 'konfirmasi'])->middleware('admin')->name('admin.konfirmasi');

Route::get('/admin/riwayat-peminjaman', [AdminController::class, 'riwayatTransaksi'])->middleware('admin')->name('admin.riwayat-transaksi');

Route::get('/admin/laporan', [AdminController::class, 'laporan'])->middleware('admin')->name('admin.laporan');

Route::get('/admin/ulasan', [AdminController::class, 'ulasan'])->middleware('admin')->name('admin.ulasan');

Route::patch('/admin/ulasan/{ulasan}', [AdminController::class, 'updateUlasan'])->middleware('admin')->name('admin.updateUlasan');

Route::delete('/admin/ulasan/{ulasan}', [AdminController::class, 'deleteUlasan'])->middleware('admin')->name('admin.deleteUlasan');

Route::get('/admin/kelola-pengguna', [AdminController::class, 'kelolaPengguna'])->middleware('admin')->name('admin.kelola-pengguna.index');
Route::get('/admin/kelola-pengguna/create', [AdminController::class, 'createPengguna'])->middleware('admin')->name('admin.kelola-pengguna.create');
Route::post('/admin/kelola-pengguna', [AdminController::class, 'storePengguna'])->middleware('admin')->name('admin.kelola-pengguna.store');
Route::get('/admin/kelola-pengguna/{user}/edit', [AdminController::class, 'editPengguna'])->middleware('admin')->name('admin.kelola-pengguna.edit');
Route::put('/admin/kelola-pengguna/{user}', [AdminController::class, 'updatePengguna'])->middleware('admin')->name('admin.kelola-pengguna.update');
Route::patch('/admin/kelola-pengguna/{user}/toggle-status', [AdminController::class, 'toggleStatus'])->middleware('admin')->name('admin.kelola-pengguna.toggle-status');
Route::delete('/admin/kelola-pengguna/{user}', [AdminController::class, 'destroyPengguna'])->middleware('admin')->name('admin.kelola-pengguna.destroy');

Route::get('/admin/kelola-petugas', [AdminController::class, 'kelolaPetugas'])->middleware('admin')->name('admin.kelola-petugas.index');
Route::patch('/admin/kelola-petugas/{user}/toggle-status', [AdminController::class, 'toggleStatusPetugas'])->middleware('admin')->name('admin.kelola-petugas.toggle-status');

Route::get('/petugas', [PetugasController::class, 'index'])->middleware('petugas')->name('petugas.dashboard');
Route::patch('/petugas/konfirmasi/{pinjaman}', [PetugasController::class, 'konfirmasi'])->middleware('petugas')->name('petugas.konfirmasi');
Route::post('/petugas/catat-pengembalian/{pinjaman}', [PetugasController::class, 'catatPengembalian'])->middleware('petugas')->name('petugas.catat-pengembalian');
Route::delete('/petugas/pinjaman/{pinjaman}', [PetugasController::class, 'destroyPinjaman'])->middleware('petugas')->name('petugas.destroy-pinjaman');
Route::get('/petugas/laporan', [PetugasController::class, 'laporan'])->middleware('petugas')->name('petugas.laporan');
Route::patch('/petugas/laporan/{laporan}/ubah-denda', [PetugasController::class, 'ubahDenda'])->middleware('petugas')->name('petugas.ubah-denda');

Route::middleware('petugas')->prefix('petugas')->name('petugas.')->group(function () {
    Route::resource('kelola-buku', PetugasBukuController::class);
});

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('kelola-buku', AdminBukuController::class);
    Route::resource('kategori', \App\Http\Controllers\Admin\KategoriController::class);
});

Route::get('/buku', [BukuController::class, 'index'])->middleware('auth')->name('buku.index');
Route::get('/buku/{id}', [BukuController::class, 'show'])->middleware('auth')->name('buku.show');
Route::post('/buku/{id}/pinjam', [BukuController::class, 'pinjamLangsung'])->middleware('auth')->name('buku.pinjamLangsung');
Route::get('/buku/{id}/pinjam', [BukuController::class, 'halamanPinjam'])->middleware('auth')->name('buku.halamanPinjam');
Route::post('/buku/pinjam', [BukuController::class, 'pinjam'])->middleware('auth')->name('buku.pinjam');
Route::post('/buku/{id}/favorit', [BukuController::class, 'toggleFavorit'])->middleware('auth')->name('buku.toggleFavorit');
Route::post('/buku/{id}/ulasan', [BukuController::class, 'simpanUlasan'])->middleware('auth')->name('buku.simpanUlasan');
Route::get('/buku/pinjam', function () {
    return redirect()->route('home');
})->middleware('auth')->name('buku.pinjam.get');
Route::get('/buku/{id}/bayar', function ($id) {
    return redirect("/buku/$id/pinjam");
})->middleware('auth')->name('buku.bayar.redirect');

Route::get('/profil', [ProfileController::class, 'index'])->middleware('auth')->name('profil.index');
Route::match(['post', 'put', 'patch'], '/profil', [ProfileController::class, 'update'])->middleware('auth')->name('profil.update');

Route::get('/tentang', [TentangController::class, 'index'])->middleware('auth')->name('tentang.index');

Route::get('/riwayat-pinjaman', function () {
    // include user as well so we can show borrower details if needed
    $pinjaman = Pinjaman::with(['buku','user'])->where('user_id', auth()->id())->get();
    return view('riwayat_pinjaman', compact('pinjaman'));
})->middleware('auth')->name('riwayat.pinjaman');
Route::get('/riwayat-pinjaman/{id}', function ($id) {
    // also eager load user so detail view can show peminjam informasi
    $pinjaman = Pinjaman::with(['buku','user'])->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    return view('detail_riwayat_pinjaman', compact('pinjaman'));
})->middleware('auth')->name('riwayat.detail');

Route::post('/riwayat-pinjaman/{id}/kembalikan', function ($id) {
    $pinjaman = Pinjaman::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    
    // Validasi status
    if (!in_array($pinjaman->status, ['approved', 'paid'])) {
        return redirect()->route('riwayat.detail', $id)->with('error', 'Buku tidak bisa dikembalikan pada status ini');
    }

    // Update catatan dengan info pengembalian
    $kondisi = request('kondisi');
    $catatanPengembalian = "Kondisi: " . ucfirst(str_replace('_', ' ', $kondisi));
    if (request('catatan')) {
        $catatanPengembalian .= " | " . request('catatan');
    }

    // Mapping kondisi dari form ke status laporan
    $kondisiMapping = [
        'sangat_baik' => 'baik',
        'baik' => 'baik',
        'cukup' => 'rusak',
        'kurang' => 'rusak',
    ];
    
    $kondisiLaporan = $kondisiMapping[$kondisi] ?? 'baik';

    // Tambah stok buku kembali
    $buku = $pinjaman->buku;
    $buku->tersedia += 1;
    $buku->save();

    $pinjaman->update([
        'status' => 'returned',
        'catatan' => $catatanPengembalian
    ]);

    // Buat laporan pengembalian
    Laporan::create([
        'pinjaman_id' => $pinjaman->id,
        'user_id' => $pinjaman->user_id,
        'buku_id' => $pinjaman->buku_id,
        'tanggal_pengembalian' => now()->toDateString(),
        'kondisi_buku' => $kondisiLaporan,
        'denda' => 0,
        'keterangan' => request('catatan'),
    ]);

    return redirect()->route('riwayat.detail', $id)->with('success', 'Buku berhasil dikembalikan. Terima kasih!');
})->middleware('auth')->name('riwayat.kembalikan');

