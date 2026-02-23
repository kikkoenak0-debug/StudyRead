<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\Buku;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // If the old `kategori` column still exists (from prior versions),
        // migrate any values into the new `kategori` table and fill
        // `kategori_id` on the books. Fresh installs will not have this
        // column, so we skip the whole process when it is absent.
        if (\Illuminate\Support\Facades\Schema::hasColumn('buku', 'kategori')) {
            // Ambil kategori unik dari tabel buku
            $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

            foreach ($kategoris as $kategori) {
                if ($kategori) {
                    Kategori::firstOrCreate(['nama' => $kategori]);
                }
            }

            // Update tabel buku dengan kategori_id
            $bukus = Buku::all();
            foreach ($bukus as $buku) {
                if ($buku->kategori) {
                    $kategori = Kategori::where('nama', $buku->kategori)->first();
                    if ($kategori) {
                        $buku->update(['kategori_id' => $kategori->id]);
                    }
                }
            }
        }

        // make sure we have some sensible categories for a new database
        $defaults = ['Teknologi','Anak','Motivasi','Sejarah','Programming'];
        foreach ($defaults as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }
    }
}