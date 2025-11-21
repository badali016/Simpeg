<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\PegawaiSimgos;

class DashboardController extends Controller
{
    /**
     * Admin dashboard: show counts and recent pegawai.
     */
    public function admin()
    {
        // If SECOND_DB_DATABASE present, count recent from SIMGOS as default
        $useSimgos = (bool) env('SECOND_DB_DATABASE');

        if ($useSimgos && class_exists(PegawaiSimgos::class)) {
            $totalPegawai = PegawaiSimgos::count();
            // load recent from SIMGOS and enrich with PROFESI DESKRIPSI + SMF->Jabatan name
            $recentRaw = PegawaiSimgos::orderBy('TANGGAL', 'desc')->take(6)->get();

            // profesi lookup
            $profLookup = [];
            if (class_exists(\App\Models\ReferensiSimgos::class)) {
                try {
                    $profLookup = \App\Models\ReferensiSimgos::where('JENIS', 36)->pluck('DESKRIPSI', 'ID')->toArray();
                } catch (\Exception $e) {
                    $profLookup = [];
                }
            }

            $recentPegawais = $recentRaw->map(function ($p) use ($profLookup) {
                // resolve profesi description and SMF->jabatan name
                $profesiNama = isset($p->PROFESI) && isset($profLookup[$p->PROFESI]) ? $profLookup[$p->PROFESI] : ($p->PROFESI ?? null);
                $jabatanName = null;
                try {
                    $jab = Jabatan::where('kode_jabatan', $p->SMF)->first();
                    $jabatanName = $jab ? $jab->nama_jabatan : ($p->SMF ?? null);
                } catch (\Exception $e) {
                    $jabatanName = $p->SMF ?? null;
                }

                return (object) [
                    'id' => $p->ID,
                    'nip' => $p->NIP,
                    'nama' => $p->NAMA,
                    'panggilan' => $p->PANGGILAN ?? null,
                    'alamat' => $p->ALAMAT ?? null,
                    'profesi' => $p->PROFESI ?? null,
                    'profesi_nama' => $profesiNama,
                    'jabatan_nama' => $jabatanName,
                    'status' => $p->STATUS ?? null,
                    'is_simgos' => true,
                ];
            });
        } else {
            $totalPegawai = Pegawai::count();
            $recentPegawais = Pegawai::with('jabatan')->latest()->take(6)->get();

            // enrich local recent pegawais with SIMGOS fields when available
            if (class_exists(PegawaiSimgos::class) && (bool) env('SECOND_DB_DATABASE')) {
                try {
                    $nips = $recentPegawais->pluck('nip')->filter()->unique()->toArray();
                    if (!empty($nips)) {
                        $smap = PegawaiSimgos::whereIn('NIP', $nips)->get()->keyBy('NIP');
                        // profesi lookup
                        $profLookup = [];
                        if (class_exists(\App\Models\ReferensiSimgos::class)) {
                            try {
                                $profLookup = \App\Models\ReferensiSimgos::where('JENIS', 36)->pluck('DESKRIPSI', 'ID')->toArray();
                            } catch (\Exception $e) {
                                $profLookup = [];
                            }
                        }

                        $recentPegawais->transform(function ($local) use ($smap, $profLookup) {
                            $nip = $local->nip ?? null;
                            if ($nip && isset($smap[$nip])) {
                                $s = $smap[$nip];
                                $local->profesi_nama = isset($profLookup[$s->PROFESI]) ? $profLookup[$s->PROFESI] : null;
                                $local->profesi = $s->PROFESI ?? null;
                                $local->simgos_jabatan_name = $s->SMF ?? null;
                                try {
                                    $jab = Jabatan::where('kode_jabatan', $s->SMF)->first();
                                    $local->simgos_jabatan_name = $jab ? $jab->nama_jabatan : ($s->SMF ?? null);
                                } catch (\Exception $e) {
                                    // ignore
                                }
                                $local->status = $local->status ?? $s->STATUS ?? null;
                            }
                            return $local;
                        });
                    }
                } catch (\Exception $e) {
                    // ignore enrichment errors
                }
            }
        }

        $totalJabatan = Jabatan::count();

        return view('dashboards.admin', compact('totalPegawai', 'totalJabatan', 'recentPegawais'));
    }

    /**
     * Pegawai dashboard: list pegawai or allow quick lookup.
     */
    public function pegawai(Request $request)
    {
        // If an ID is provided, show that pegawai profile; otherwise show list.
        // detect SIMGOS usage like in PegawaiController
        $source = $request->get('source');
        if ($request->has('source')) {
            $useSimgos = $source === 'simgos';
        } else {
            $useSimgos = (bool) env('SECOND_DB_DATABASE');
        }

        if ($request->has('id')) {
            if ($useSimgos && class_exists(PegawaiSimgos::class)) {
                $p = PegawaiSimgos::findOrFail($request->input('id'));
                $pegawai = (object) [
                    'id' => $p->ID,
                    'nip' => $p->NIP,
                    'nama' => $p->NAMA,
                    'panggilan' => $p->PANGGILAN ?? null,
                    'alamat' => $p->ALAMAT ?? null,
                    'status' => $p->STATUS ?? null,
                    'is_simgos' => true,
                ];
                return view('dashboards.pegawai-profile', compact('pegawai'));
            }

            $pegawai = Pegawai::with('jabatan')->findOrFail($request->input('id'));
            return view('dashboards.pegawai-profile', compact('pegawai'));
        }

        if ($useSimgos && class_exists(PegawaiSimgos::class)) {
            $pegawais = PegawaiSimgos::orderBy('TANGGAL', 'desc')->paginate(10);
            // normalize for dashboard view
            $pegawais->getCollection()->transform(function ($p) {
                return (object) [
                    'id' => $p->ID,
                    'nip' => $p->NIP,
                    'nama' => $p->NAMA,
                    'panggilan' => $p->PANGGILAN ?? null,
                    'alamat' => $p->ALAMAT ?? null,
                    'status' => $p->STATUS ?? null,
                    'is_simgos' => true,
                ];
            });
        } else {
            $pegawais = Pegawai::with('jabatan')->orderBy('nama')->paginate(10);
        }

        return view('dashboards.pegawai', compact('pegawais'));
    }
}
