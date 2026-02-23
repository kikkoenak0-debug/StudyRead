<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'isbn',
        'kategori_id',
        'tersedia',
        'foto',
        'sinopsis',
        'tahun_terbit',
        'user_id',
    ];

    protected $casts = [
        'tahun_terbit' => 'date:Y-m-d',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
