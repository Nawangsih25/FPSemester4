<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $appends = ['tagihan_hari_ini'];

    protected $casts = [
        'nominal' => 'float',
        'sisa_tagihan' => 'float',
        'bunga' => 'float',
        'denda' => 'float',
        'tanggal_pinjam' => 'datetime',
        'tanggal_respon' => 'datetime',
        'lama_angsuran' => 'integer',
    ];

    // public function getTagihanHariIniAttribute()
    // {
    //     if (!in_array($this->status, ['belum bayar', 'sudah bayar']) || !$this->lama_angsuran || $this->sisa_tagihan <= 0) {
    //         return 0;
    //     }

    //     $totalHari = $this->lama_angsuran * 30;

    //     return ($totalHari > 0) ? round($this->sisa_tagihan / $totalHari, 2) : 0;
    // }

    public function getTagihanHariIniAttribute()
    {
        if (!in_array($this->status, ['belum bayar', 'sudah bayar']) || !$this->lama_angsuran) {
            return 0;
        }

        $totalTagihan = $this->nominal + ($this->nominal * 0.05); // nominal + bunga 5%
        $bulan = $this->lama_angsuran * 30;

        return ($bulan > 0) ? round($totalTagihan / $bulan, 2) : 0;
    }


    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

}
