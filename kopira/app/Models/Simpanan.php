<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'jenis',
        'tanggal',
        'total_simpanan_wajib',
        'total_simpanan_sukarela',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    protected static function booted()
    {
        static::created(function ($simpanan) {
            \App\Models\Transaksi::create([
                'anggota_id' => $simpanan->anggota_id,
                'jenis' => $simpanan->jenis,
                'jumlah' => $simpanan->jumlah,
                'tanggal' => $simpanan->tanggal,
                'keterangan' => 'Simpanan ' . ucfirst($simpanan->jenis),
            ]);
        });
    }

}
