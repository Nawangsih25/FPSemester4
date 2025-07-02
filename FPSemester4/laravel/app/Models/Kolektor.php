<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kolektor extends Model
{
    use HasFactory;

    protected $table = 'kolektor';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'pendidikan',
        'tanggal_daftar',
        'foto',
    ];

    public function anggota()
    {
        return $this->belongsToMany(Anggota::class, 'relasi_kolektor_anggota', 'kolektor_id', 'anggota_id')
            ->withPivot('id') // Penting untuk dapat ID relasi pivot
            ->withTimestamps();
    }
}