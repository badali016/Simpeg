<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\PegawaiSimgos;
use App\Models\ReferensiSimgos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Decide data source: explicit ?source=simgos overrides, otherwise if SECOND_DB_DATABASE is set use SIMGOS by default
        $source = $request->get('source');
        $useSimgos = false;
        if ($request->has('source')) {
            $useSimgos = $source === 'simgos';
        } else {
            $useSimgos = (bool) env('SECOND_DB_DATABASE');
        }

        if ($useSimgos && class_exists(PegawaiSimgos::class)) {
            $pag = PegawaiSimgos::orderBy('TANGGAL', 'desc')->paginate(10);

            // load PROFESI and AGAMA/JENIS_KELAMIN referensi once from SIMGOS if available
            $profesiLookup = [];
            $agamaLookup = [];
            $jkLookup = [];
            if (class_exists(ReferensiSimgos::class)) {
                try {
                    $profesiLookup = ReferensiSimgos::where('JENIS', 36)->orderBy('DESKRIPSI')->pluck('DESKRIPSI', 'ID')->toArray();
                } catch (\Exception $e) {
                    $profesiLookup = [];
                }
                try {
                    $agamaLookup = ReferensiSimgos::where('JENIS', 1)->orderBy('DESKRIPSI')->pluck('DESKRIPSI', 'ID')->toArray();
                } catch (\Exception $e) {
                    $agamaLookup = [];
                }
                try {
                    $jkLookup = ReferensiSimgos::where('JENIS', 2)->orderBy('DESKRIPSI')->pluck('DESKRIPSI', 'ID')->toArray();
                } catch (\Exception $e) {
                    $jkLookup = [];
                }
            }

            // normalize attributes so views can use the same keys as local model
            $pag->getCollection()->transform(function ($p) use ($profesiLookup, $agamaLookup, $jkLookup) {
                // try to resolve SMF -> Jabatan name
                $jabatanName = null;
                try {
                    $jab = Jabatan::where('kode_jabatan', $p->SMF)->first();
                    $jabatanName = $jab ? $jab->nama_jabatan : ($p->SMF ?? null);
                } catch (\Exception $e) {
                    $jabatanName = $p->SMF ?? null;
                }

                $profesiNama = $p->PROFESI ?? null;
                if ($profesiNama !== null && isset($profesiLookup[$p->PROFESI])) {
                    $profesiNama = $profesiLookup[$p->PROFESI];
                }

                $agamaNama = $p->AGAMA ?? null;
                if ($agamaNama !== null && isset($agamaLookup[$p->AGAMA])) {
                    $agamaNama = $agamaLookup[$p->AGAMA];
                }

                $jkNama = $p->JENIS_KELAMIN ?? null;
                if ($jkNama !== null && isset($jkLookup[$p->JENIS_KELAMIN])) {
                    $jkNama = $jkLookup[$p->JENIS_KELAMIN];
                }

                return (object) [
                    'id' => $p->ID,
                    'nip' => $p->NIP,
                    'nama' => $p->NAMA,
                    'panggilan' => $p->PANGGILAN,
                    'gelar_depan' => $p->GELAR_DEPAN ?? null,
                    'gelar_belakang' => $p->GELAR_BELAKANG ?? null,
                    'tempat_lahir' => $p->TEMPAT_LAHIR ?? null,
                    'tanggal_lahir' => isset($p->TANGGAL_LAHIR) && $p->TANGGAL_LAHIR ? $p->TANGGAL_LAHIR->format('Y-m-d') : null,
                    'profesi' => $p->PROFESI ?? null,
                    'profesi_nama' => $profesiNama,
                    'smf' => $p->SMF ?? null,
                    'jabatan' => $jabatanName,
                    'alamat' => $p->ALAMAT ?? null,
                    'rt' => $p->RT ?? null,
                    'rw' => $p->RW ?? null,
                    'kodepos' => $p->KODEPOS ?? null,
                    'wilayah' => $p->WILAYAH ?? null,
                    'email' => $p->EMAIL ?? null,
                    'agama' => $p->AGAMA ?? null,
                    'agama_nama' => $agamaNama,
                    'jenis_kelamin' => $p->JENIS_KELAMIN ?? null,
                    'jenis_kelamin_nama' => $jkNama,
                    'tanggal' => $p->TANGGAL ?? null,
                    'non_pegawai' => $p->NON_PEGAWAI ?? null,
                    'status' => $p->STATUS ?? null,
                    'is_simgos' => true,
                ];
            });

            $pegawais = $pag;
            return view('pegawai.index', compact('pegawais'));
        }

        $pegawais = Pegawai::with('jabatan')->orderBy('created_at', 'desc')->paginate(10);

        // Enrich local pegawais with SIMGOS fields when available (lookup by NIP)
        if (class_exists(PegawaiSimgos::class) && (bool) env('SECOND_DB_DATABASE')) {
            try {
                $nips = $pegawais->getCollection()->pluck('nip')->filter()->unique()->toArray();
                if (!empty($nips)) {
                    $smap = PegawaiSimgos::whereIn('NIP', $nips)->get()->keyBy('NIP');

                    // load profesi, agama and jenis_kelamin lookups
                    $profLookup = [];
                    $agamaLookup = [];
                    $jkLookup = [];
                    if (class_exists(ReferensiSimgos::class)) {
                        try {
                            $profLookup = ReferensiSimgos::where('JENIS', 36)->pluck('DESKRIPSI', 'ID')->toArray();
                        } catch (\Exception $e) {
                            $profLookup = [];
                        }
                        try {
                            $agamaLookup = ReferensiSimgos::where('JENIS', 1)->pluck('DESKRIPSI', 'ID')->toArray();
                        } catch (\Exception $e) {
                            $agamaLookup = [];
                        }
                        try {
                            $jkLookup = ReferensiSimgos::where('JENIS', 2)->pluck('DESKRIPSI', 'ID')->toArray();
                        } catch (\Exception $e) {
                            $jkLookup = [];
                        }
                    }

                    $pegawais->getCollection()->transform(function ($local) use ($smap, $profLookup, $agamaLookup, $jkLookup) {
                        $nip = $local->nip ?? null;
                        if ($nip && isset($smap[$nip])) {
                            $s = $smap[$nip];
                            // attach simgos_* properties for view fallback
                            $local->simgos_nama = $s->NAMA ?? null;
                            $local->simgos_panggilan = $s->PANGGILAN ?? null;
                            $local->simgos_email = $s->EMAIL ?? null;
                            $local->simgos_alamat = $s->ALAMAT ?? null;
                            $local->simgos_profesi = $s->PROFESI ?? null;
                            $local->simgos_profesi_nama = isset($profLookup[$s->PROFESI]) ? $profLookup[$s->PROFESI] : null;
                            $local->simgos_agama = $s->AGAMA ?? null;
                            $local->simgos_agama_nama = isset($agamaLookup[$s->AGAMA]) ? $agamaLookup[$s->AGAMA] : null;
                            $local->simgos_jenis_kelamin = $s->JENIS_KELAMIN ?? null;
                            $local->simgos_jenis_kelamin_nama = isset($jkLookup[$s->JENIS_KELAMIN]) ? $jkLookup[$s->JENIS_KELAMIN] : null;
                            $local->simgos_smf = $s->SMF ?? null;
                            // try resolve SMF to jabatan name
                            try {
                                $jab = Jabatan::where('kode_jabatan', $s->SMF)->first();
                                $local->simgos_jabatan_name = $jab ? $jab->nama_jabatan : ($s->SMF ?? null);
                            } catch (\Exception $e) {
                                $local->simgos_jabatan_name = $s->SMF ?? null;
                            }
                            $local->simgos_status = $s->STATUS ?? null;
                        }
                        return $local;
                    });
                }
            } catch (\Exception $e) {
                // ignore enrichment errors
            }
        }

        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // prefer profesi list from SIMGOS when available
        $profesiList = [];
        if (class_exists(ReferensiSimgos::class) && (bool) env('SECOND_DB_DATABASE')) {
            try {
                // get mapping ID => DESKRIPSI for JENIS=36 (PROFESI)
                $profesiList = ReferensiSimgos::where('JENIS', 36)->orderBy('DESKRIPSI')->pluck('DESKRIPSI', 'ID')->toArray();
            } catch (\Exception $e) {
                $profesiList = [];
            }
        }

        // fallback to local jabatan names if SIMGOS not available (use id=>label shape)
        if (empty($profesiList)) {
            $profesiList = Jabatan::orderBy('nama_jabatan')->pluck('nama_jabatan', 'id')->toArray();
        }

        return view('pegawai.create', compact('profesiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'profesi' => 'nullable|integer',
            'nip' => 'required|string|max:50|unique:pegawais,nip',
            'email' => 'nullable|email|max:255|unique:pegawais,email',
            'panggilan' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:150',
        ]);

        $new = Pegawai::create($data);

        // Dual-write to SIMGOS if enabled (non-fatal)
        if ((bool) env('SECOND_DB_WRITE', false) && class_exists(PegawaiSimgos::class)) {
            try {
                $sData = [
                    'NIP' => $new->nip,
                    'NAMA' => $new->nama,
                    'PANGGILAN' => $new->panggilan,
                    'EMAIL' => $new->email,
                    'ALAMAT' => $new->alamat,
                    'PROFESI' => $new->profesi ?? null,
                    'SMF' => $new->smf ?? null,
                    'TANGGAL' => Carbon::now(),
                    'STATUS' => $new->status ?? 1,
                ];

                // update if exists by NIP, otherwise create
                PegawaiSimgos::updateOrCreate(['NIP' => $new->nip], $sData);
            } catch (\Exception $e) {
                Log::error('Failed to write pegawai to SIMGOS: ' . $e->getMessage(), ['nip' => $new->nip]);
            }
        }

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        // support viewing a SIMGOS record via ?source=simgos, or default to SIMGOS if SECOND_DB_DATABASE present and source not provided
        $source = $request->get('source');
        if ($request->has('source')) {
            $useSimgos = $source === 'simgos';
        } else {
            $useSimgos = (bool) env('SECOND_DB_DATABASE');
        }

        if ($useSimgos && class_exists(PegawaiSimgos::class)) {
            $p = PegawaiSimgos::findOrFail($id);
            // resolve SMF -> Jabatan name if possible
            $jabatanName = null;
            try {
                $jab = Jabatan::where('kode_jabatan', $p->SMF)->first();
                $jabatanName = $jab ? $jab->nama_jabatan : ($p->SMF ?? null);
            } catch (\Exception $e) {
                $jabatanName = $p->SMF ?? null;
            }

            $pegawai = (object) [
                'id' => $p->ID,
                'nip' => $p->NIP,
                'nama' => $p->NAMA,
                'panggilan' => $p->PANGGILAN ?? null,
                'gelar_depan' => $p->GELAR_DEPAN ?? null,
                'gelar_belakang' => $p->GELAR_BELAKANG ?? null,
                'tempat_lahir' => $p->TEMPAT_LAHIR ?? null,
                'tanggal_lahir' => isset($p->TANGGAL_LAHIR) && $p->TANGGAL_LAHIR ? $p->TANGGAL_LAHIR->format('Y-m-d') : null,
                'agama' => $p->AGAMA ?? null,
                'jenis_kelamin' => $p->JENIS_KELAMIN ?? null,
                'profesi' => $p->PROFESI ?? null,
                'smf' => $p->SMF ?? null,
                'jabatan' => $jabatanName,
                'alamat' => $p->ALAMAT ?? null,
                'rt' => $p->RT ?? null,
                'rw' => $p->RW ?? null,
                'kodepos' => $p->KODEPOS ?? null,
                'wilayah' => $p->WILAYAH ?? null,
                'email' => $p->EMAIL ?? null,
                'tanggal' => $p->TANGGAL ?? null,
                'non_pegawai' => $p->NON_PEGAWAI ?? null,
                'status' => $p->STATUS ?? null,
                'is_simgos' => true,
            ];

            return view('pegawai.show', compact('pegawai'));
        }

        $pegawai = Pegawai::with('jabatan')->findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $profesiList = [];
        if (class_exists(ReferensiSimgos::class) && (bool) env('SECOND_DB_DATABASE')) {
            try {
                $profesiList = ReferensiSimgos::where('JENIS', 36)->orderBy('DESKRIPSI')->pluck('DESKRIPSI', 'ID')->toArray();
            } catch (\Exception $e) {
                $profesiList = [];
            }
        }

        if (empty($profesiList)) {
            $profesiList = Jabatan::orderBy('nama_jabatan')->pluck('nama_jabatan', 'id')->toArray();
        }

        return view('pegawai.edit', compact('pegawai', 'profesiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

            $data = $request->validate([
                'nama' => 'required|string|max:255',
                'profesi' => 'nullable|integer',
                'nip' => 'required|string|max:50|unique:pegawais,nip,' . $pegawai->id,
                'email' => 'nullable|email|max:255|unique:pegawais,email,' . $pegawai->id,
                'panggilan' => 'nullable|string|max:15',
                'alamat' => 'nullable|string|max:150',
            ]);

        $pegawai->update($data);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }

    /**
     * Import a record from SIMGOS into local pegawais table.
     */
    public function import(string $id)
    {
        // Fetch from SIMGOS
        if (!class_exists(PegawaiSimgos::class)) {
            return redirect()->route('admin.pegawai.index')->with('error', 'Koneksi SIMGOS tidak tersedia.');
        }

        $p = PegawaiSimgos::findOrFail($id);
        // map fields (adjust as needed)
        $data = [
            'nip' => $p->NIP,
            'nama' => $p->NAMA,
            'panggilan' => $p->PANGGILAN ?? null,
            'gelar_depan' => $p->GELAR_DEPAN ?? null,
            'gelar_belakang' => $p->GELAR_BELAKANG ?? null,
            'tempat_lahir' => $p->TEMPAT_LAHIR ?? null,
            'tanggal_lahir' => isset($p->TANGGAL_LAHIR) && $p->TANGGAL_LAHIR ? $p->TANGGAL_LAHIR->format('Y-m-d') : null,
            'agama' => $p->AGAMA ?? null,
            'jenis_kelamin' => $p->JENIS_KELAMIN ?? null,
            'profesi' => $p->PROFESI ?? null,
            'smf' => $p->SMF ?? null,
            'alamat' => $p->ALAMAT ?? null,
            'rt' => $p->RT ?? null,
            'rw' => $p->RW ?? null,
            'kodepos' => $p->KODEPOS ?? null,
            'wilayah' => $p->WILAYAH ?? null,
            'email' => $p->EMAIL ?? null,
            'tanggal' => $p->TANGGAL ?? null,
            'non_pegawai' => $p->NON_PEGAWAI ?? null,
            'status' => $p->STATUS ?? null,
        ];

        // try to map PROFESI -> jabatan_id (create jabatan if missing)
        $jabatanId = null;
        try {
            if (isset($p->PROFESI) && class_exists(ReferensiSimgos::class)) {
                $ref = ReferensiSimgos::where('JENIS', 36)->where('ID', $p->PROFESI)->first();
                $kode = 'PRF-' . ($p->PROFESI ?? '0');
                $nama = $ref->DESKRIPSI ?? ('Profesi ' . ($p->PROFESI ?? ''));
                $jab = Jabatan::firstOrCreate(['kode_jabatan' => $kode], ['nama_jabatan' => $nama, 'eselon' => null, 'unit_kerja' => null, 'status' => 'Aktif']);
                $jabatanId = $jab->id ?? null;
            }
        } catch (\Exception $e) {
            // ignore mapping failure, proceed without jabatan_id
            $jabatanId = null;
        }

        if ($jabatanId) {
            $data['jabatan_id'] = $jabatanId;
        }

        // Avoid duplicate by NIP
        $existing = Pegawai::where('nip', $p->NIP)->first();
        if ($existing) {
            return redirect()->route('admin.pegawai.edit', $existing->id)->with('info', 'Pegawai sudah terdaftar secara lokal.');
        }

        $new = Pegawai::create($data);

        return redirect()->route('admin.pegawai.edit', $new->id)->with('success', 'Data pegawai berhasil diimpor dari SIMGOS.');
    }
}
