<?php

namespace App\Http\Controllers;

use App\Models\ReferensiSimgos;
use Illuminate\Http\Request;
use App\Models\PegawaiSimgos;

class PegawaiSimgosController extends Controller
{
    // mapping field => referensi jenis
    private $refMap = [
        'AGAMA' => 1,
        'JENIS_KELAMIN' => 2,
        'PROFESI' => 36,
        'SMF' => 26,
    ];

    public function index()
    {
        // ambil semua pegawai dan referensi yang diperlukan
        $pegawaiList = PegawaiSimgos::all();
        $referensi = $this->getReferensiForFields();
        
        // transform setiap record agar nilai numeric diganti dengan DESKRIPSI
        $transformed = $pegawaiList->map(function ($p) use ($referensi) {
            return $this->applyReferensi($p->toArray(), $referensi);
        });

        return response()->json($transformed, 200);
    }

    // kembalikan 1 pegawai berdasarkan ID (ditransform juga)
    public function show($id)
    {
        $pegawai = PegawaiSimgos::find($id);

        if (! $pegawai) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $referensi = $this->getReferensiForFields();
        $transformed = $this->applyReferensi($pegawai->toArray(), $referensi);

        return response()->json($transformed, 200);
    }

    // contoh mencari berdasarkan NIP (query param ?nip=...)
    public function findByNip(Request $request)
    {
        $nip = $request->query('nip');
        if (! $nip) {
            return response()->json(['message' => 'Parameter nip dibutuhkan'], 400);
        }

        $pegawai = PegawaiSimgos::where('NIP', $nip)->first();

        if (! $pegawai) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $referensi = $this->getReferensiForFields();
        $transformed = $this->applyReferensi($pegawai->toArray(), $referensi);

        return response()->json($transformed, 200);
    }

    // ambil referensi yang diperlukan dan buat lookup [JENIS][ID] => DESKRIPSI
    private function getReferensiForFields()
    {
        $jenisList = array_values($this->refMap);
        $refs = ReferensiSimgos::whereIn('JENIS', $jenisList)->get();

        $lookup = [];
        foreach ($refs as $r) {
            $lookup[(int)$r->JENIS][(int)$r->ID] = $r->DESKRIPSI;
        }

        return $lookup;
    }

    // terapkan referensi ke array pegawai
    private function applyReferensi(array $pegawai, array $referensi)
    {
        foreach ($this->refMap as $field => $jenis) {
            // simpan ID asli (jika ingin tetap tersedia) lalu replace field dengan DESKRIPSI
            $orig = array_key_exists($field, $pegawai) ? $pegawai[$field] : null;

            // default kalau tidak ditemukan
            $deskripsi = null;
            if ($orig !== null && isset($referensi[$jenis]) && isset($referensi[$jenis][(int)$orig])) {
                $deskripsi = $referensi[$jenis][(int)$orig];
            }

            // jika ingin menampilkan hanya deskripsi: replace
            $pegawai[$field] = $deskripsi;

            // optional: simpan ID asli ke field baru (bisa dihapus jika tidak dibutuhkan)
            $pegawai[$field . '_ID'] = $orig;
        }

        return $pegawai;
    }
}
