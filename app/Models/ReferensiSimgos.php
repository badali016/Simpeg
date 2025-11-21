<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferensiSimgos extends Model
{
    protected $connection = 'SIMGOS';
    protected $table = 'referensi';
    protected $primaryKey = 'TABEL_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'JENIS',
        'ID',
        'DESKRIPSI',
        'TEKS',
    ];

    protected $casts = [
        'TABEL_ID' => 'integer',
        'JENIS' => 'integer',
        'ID' => 'integer',
        'CONFIG' => 'array',
        'SCORING' => 'integer',
        'STATUS' => 'integer',
    ];
}
