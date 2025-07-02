<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    
    protected $table = 'anggota';

    protected $fillable = [
        'no_rekening',
        'nama',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'telepon',
        'alamat',
        'pekerjaan',
        'pendidikan',
        'tanggal_daftar',
        'status',
        'deposito_awal',
        'foto',
    ];

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class, 'anggota_id');
    }

    public function kolektor()
    {
        return $this->belongsToMany(Kolektor::class, 'relasi_kolektor_anggota', 'anggota_id', 'kolektor_id')
            ->withPivot('id') // Agar bisa akses $kolektor->pivot->id
            ->withTimestamps();
    }

    public function pinjaman()
    {
        return $this->hasMany(\App\Models\Pinjaman::class);
    }

}

