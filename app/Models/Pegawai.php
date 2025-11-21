<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'jabatan_id',
        'nip',
        'nama',
        'panggilan',
        'gelar_depan',
        'gelar_belakang',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'jenis_kelamin',
        'profesi',
        'smf',
        'alamat',
        'rt',
        'rw',
        'kodepos',
        'wilayah',
        'tanggal',
        'non_pegawai',
        'status',
        'email',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }  
}
