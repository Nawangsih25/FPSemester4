<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'anggota_id',
        'kode_transaksi',
        'jenis',
        'keterangan',
        'jumlah',
        'tanggal',
    ];

    // Relasi ke anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
}