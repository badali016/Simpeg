<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'type', // in|out
        'latitude',
        'longitude',
        'geofence_ok',
        'notes',
        'recorded_at',
    ];

    protected $casts = [
        'geofence_ok' => 'boolean',
        'recorded_at' => 'datetime',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
