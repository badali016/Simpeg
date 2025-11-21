<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'nip',
        'nama',
        'panggilan',
        'gelas_depan',
        'gelas_belakang',
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
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }  
}
