<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPegawai
{
    /**
     * Allow only authenticated users who are linked to a pegawai record.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (! $user || ! $user->pegawai_id) {
            abort(403, 'Akses ditolak. Hanya pegawai terdaftar yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
