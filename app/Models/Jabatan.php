<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
            protected $fillable = [
                'nama_jabatan',
                'kode_jabatan',
                'eselon',
                'unit_kerja',
                'status',
            ];
        
            use HasFactory;
    
            public function pegawais()
            {
                return $this->hasMany(Pegawai::class);
            }
    }


