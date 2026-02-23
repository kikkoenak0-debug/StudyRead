<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Str;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This will generate several sample books and associate them with the
     * first admin/user account it can find. The intent is simply to populate
     * the kelola-buku index so the page isn't empty during development.
     *
     * Run with: php artisan db:seed --class=BukuSeeder
     *
     * @return void
     */
    public function run()
    {
        // make sure there is at least one user to associate
        $user = User::where('role', 'admin')->orWhere('role', 'petugas')->first();
        if (! $user) {
            // pick any user if no admin/petugas found
            $user = User::first();
        }

        // We'll pick or create some categories to attach
        $catTech = \App\Models\Kategori::firstOrCreate(['nama' => 'Teknologi']);
        $catAnak = \App\Models\Kategori::firstOrCreate(['nama' => 'Anak']);
        $catMotivasi = \App\Models\Kategori::firstOrCreate(['nama' => 'Motivasi']);
        $catSejarah = \App\Models\Kategori::firstOrCreate(['nama' => 'Sejarah']);
        $catProgramming = \App\Models\Kategori::firstOrCreate(['nama' => 'Programming']);

        $samples = [
            [
                'judul' => 'Belajar Laravel: Dasar hingga Mahir',
                'penulis' => 'Siti Nurhayati',
                'penerbit' => 'PT. Koding Nusantara',
                'tahun_terbit' => '2022-06-15',
                'isbn' => '978-602-1234-56-7',
                'kategori_id' => $catTech->id,
                'tersedia' => 5,
                'sinopsis' => 'Panduan lengkap mempelajari Laravel dari instalasi sampai deployment.',
            ],
            [
                'judul' => 'Petualangan Si Kancil',
                'penulis' => 'A. Satya',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => '2018-03-10',
                'isbn' => '978-602-9876-54-3',
                'kategori_id' => $catAnak->id,
                'tersedia' => 3,
                'sinopsis' => 'Kumpulan cerita rakyat Nusantara tentang kecerdikan seekor kancil.',
            ],
            [
                'judul' => 'Menjadi Pemimpin Hebat',
                'penulis' => 'Bambang Sutrisno',
                'penerbit' => 'Pustaka Inspirasi',
                'tahun_terbit' => '2020-11-01',
                'isbn' => '978-602-4567-89-0',
                'kategori_id' => $catMotivasi->id,
                'tersedia' => 7,
                'sinopsis' => 'Kiat-kiat praktis untuk mengasah kemampuan kepemimpinan dalam berbagai bidang.',
            ],
            [
                'judul' => 'Sejarah Dunia dalam 100 Buku',
                'penulis' => 'Dewi Lestari',
                'penerbit' => 'Historia',
                'tahun_terbit' => '2019-08-20',
                'isbn' => '978-602-3344-22-1',
                'kategori_id' => $catSejarah->id,
                'tersedia' => 4,
                'sinopsis' => 'Ringkasan penting dalam sejarah dunia yang harus dibaca oleh generasi muda.',
            ],
            [
                'judul' => 'Koding Python Untuk Pemula',
                'penulis' => 'Andi Wijaya',
                'penerbit' => 'TeknoPress',
                'tahun_terbit' => '2021-01-05',
                'isbn' => '978-602-7654-32-8',
                'kategori_id' => $catProgramming->id,
                'tersedia' => 6,
                'sinopsis' => 'Buku entry-level untuk menulis program menggunakan bahasa Python.',
            ],
        ];

        foreach ($samples as $data) {
            $data['user_id'] = $user ? $user->id : null;
            Buku::firstOrCreate([
                'isbn' => $data['isbn'],
            ], $data);
        }

        $this->command->info('✅ Sample books inserted (if not already present).');
    }
}
