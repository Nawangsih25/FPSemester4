<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $status
 * @property float $sisa_tagihan
 * @property int $lama_angsuran
 * @property \Illuminate\Database\Eloquent\Collection $pembayaran
 */

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';

    protected $fillable = [
        'anggota_id',
        'nominal',
        'tanggal_pinjam',
        'lama_angsuran',
        'status',
        'tanggal_respon',
        'alasan_penolakan',
        'bunga',
        'sisa_tagihan',
        'denda',
        'tagihan_hari_ini',
    ];

    // ⬇️ Tambahkan di sini
    // protected $appends = ['tagihan_hari_ini'];

    // public function getTagihanHariIniAttribute()
    // {
    //     if (!in_array($this->status, ['belum bayar', 'sudah bayar']) || !$this->lama_angsuran || $this->sisa_tagihan <= 0) {
    //         return 0;
    //     }

    //     $totalHari = $this->lama_angsuran * 30;

    //     if ($totalHari <= 0) {
    //         return 0;
    //     }

    //     return round($this->sisa_tagihan / $totalHari, 2);
    // }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}

