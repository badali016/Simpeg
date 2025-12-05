<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'type', // cuti|izin|sakit|dinas_luar
        'starts_at',
        'ends_at',
        'reason',
        'proof_path',
        'status', // pending/approved/rejected
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
