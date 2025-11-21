<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pegawai',
        'nip',
        'jabatan_id',
        'email',
        'no_telepon',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }  
}
