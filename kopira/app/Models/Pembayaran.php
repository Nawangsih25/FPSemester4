<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pinjaman_id',
        'tanggal_pembayaran',
        'jumlah_pembayaran',
        'bukti_pembayaran',
        'status_verifikasi',
        'catatan_admin',
        'metode',
    ];

    // Relasi ke Pinjaman
    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
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
