<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiKolektorAnggota extends Model
{
    use HasFactory;
    protected $table = 'relasi_kolektor_anggota';

    protected $fillable = ['kolektor_id', 'anggota_id'];

    public function kolektor()
    {
        return $this->belongsTo(Kolektor::class);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
