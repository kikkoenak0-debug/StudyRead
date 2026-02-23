<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan_pengembalian';

    protected $fillable = [
        'pinjaman_id',
        'user_id',
        'buku_id',
        'tanggal_pengembalian',
        'denda',
        'keterangan',
        'kondisi_buku',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
