<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiSimgos extends Model
{
    protected $connection = 'SIMGOS';
    protected $table = 'pegawai';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
        'NIP',
        'NAMA',
        'PANGGILAN',
        'GELAR_DEPAN',
        'GELAR_BELAKANG',
        'TEMPAT_LAHIR',
        'TANGGAL_LAHIR',
        'AGAMA',
        'JENIS_KELAMIN',
        'PROFESI',
        'SMF',
        'ALAMAT',
        'RT',
        'RW',
        'KODEPOS',
        'WILAYAH',
        'TANGGAL',
        'NON_PEGAWAI',
        'STATUS',
    ];

    protected $casts = [
        'ID' => 'integer',
        'TANGGAL_LAHIR' => 'datetime',
        'TANGGAL' => 'datetime',
        'AGAMA' => 'integer',
        'JENIS_KELAMIN' => 'integer',
        'PROFESI' => 'integer',
        'SMF' => 'integer',
        'NON_PEGAWAI' => 'integer',
        'STATUS' => 'integer',
    ];
}