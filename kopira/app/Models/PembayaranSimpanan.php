<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranSimpanan extends Model
{
    use HasFactory;

    // ✅ Atur nama tabel secara eksplisit
    protected $table = 'pembayaran_simpanan';

    // ✅ Field yang bisa diisi
    protected $fillable = [
        'anggota_id',
        'jenis',
        'jumlah',
        'metode',
        'tanggal',
        'bukti_pembayaran',
        'status',
    ];
    
    protected $dates = ['tanggal'];
    // ✅ Relasi ke tabel anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
}
