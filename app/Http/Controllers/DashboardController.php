<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;

class DashboardController extends Controller
{
    /**
     * Admin dashboard: show counts and recent pegawai.
     */
    public function admin()
    {
        $totalPegawai = Pegawai::count();
        $totalJabatan = Jabatan::count();
        $recentPegawais = Pegawai::with('jabatan')->latest()->take(6)->get();

        return view('dashboards.admin', compact('totalPegawai', 'totalJabatan', 'recentPegawais'));
    }

    /**
     * Pegawai dashboard: list pegawai or allow quick lookup.
     */
    public function pegawai(Request $request)
    {
        // If an ID is provided, show that pegawai profile; otherwise show list.
        if ($request->has('id')) {
            $pegawai = Pegawai::with('jabatan')->findOrFail($request->input('id'));
            return view('dashboards.pegawai-profile', compact('pegawai'));
        }

        $pegawais = Pegawai::with('jabatan')->orderBy('nama_pegawai')->paginate(10);
        return view('dashboards.pegawai', compact('pegawais'));
    }
}
