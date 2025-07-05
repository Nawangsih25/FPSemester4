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

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
