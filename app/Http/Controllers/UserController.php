<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\PegawaiSimgos;
use App\Models\ReferensiSimgos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('pegawai')->orderBy('id', 'desc')->paginate(20);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $pegawais = Pegawai::orderBy('nama')->get();

        $pegawaisSimgos = [];
        if (class_exists(PegawaiSimgos::class) && (bool) env('SECOND_DB_DATABASE')) {
            try {
                $pegawaisSimgos = PegawaiSimgos::orderBy('NAMA')->limit(200)->get();
            } catch (\Exception $e) {
                $pegawaisSimgos = [];
            }
        }

        return view('users.create', compact('pegawais', 'pegawaisSimgos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'pegawai_ref' => 'nullable|string',
            'is_admin' => 'sometimes|boolean',
        ]);

        // Resolve pegawai_ref: supports "local-{id}" or "simgos-{nip}". If simgos selected, import into local pegawais table.
        $pegawaiId = null;
        if (!empty($data['pegawai_ref'])) {
            if (str_starts_with($data['pegawai_ref'], 'local-')) {
                $pegawaiId = intval(substr($data['pegawai_ref'], 6));
            } elseif (str_starts_with($data['pegawai_ref'], 'simgos-') && class_exists(PegawaiSimgos::class)) {
                $nip = substr($data['pegawai_ref'], 7);
                try {
                    $s = PegawaiSimgos::where('NIP', $nip)->first();
                    if ($s) {
                        // avoid duplicates by NIP
                        $existing = Pegawai::where('nip', $s->NIP)->first();
                        if ($existing) {
                            $pegawaiId = $existing->id;
                        } else {
                            // map essential fields
                            $toCreate = [
                                'nip' => $s->NIP,
                                'nama' => $s->NAMA,
                                'panggilan' => $s->PANGGILAN ?? null,
                                'gelar_depan' => $s->GELAR_DEPAN ?? null,
                                'gelar_belakang' => $s->GELAR_BELAKANG ?? null,
                                'tempat_lahir' => $s->TEMPAT_LAHIR ?? null,
                                'tanggal_lahir' => isset($s->TANGGAL_LAHIR) && $s->TANGGAL_LAHIR ? $s->TANGGAL_LAHIR->format('Y-m-d') : null,
                                'agama' => $s->AGAMA ?? null,
                                'jenis_kelamin' => $s->JENIS_KELAMIN ?? null,
                                'profesi' => $s->PROFESI ?? null,
                                'smf' => $s->SMF ?? null,
                                'alamat' => $s->ALAMAT ?? null,
                                'rt' => $s->RT ?? null,
                                'rw' => $s->RW ?? null,
                                'kodepos' => $s->KODEPOS ?? null,
                                'wilayah' => $s->WILAYAH ?? null,
                                'email' => $s->EMAIL ?? null,
                                'tanggal' => $s->TANGGAL ?? null,
                                'non_pegawai' => $s->NON_PEGAWAI ?? null,
                                'status' => $s->STATUS ?? null,
                            ];
                            $created = Pegawai::create($toCreate);
                            $pegawaiId = $created->id ?? null;
                        }
                    }
                } catch (\Exception $e) {
                    $pegawaiId = null;
                }
            }
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'pegawai_id' => $pegawaiId,
            'is_admin' => isset($data['is_admin']) ? (bool)$data['is_admin'] : false,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $pegawais = Pegawai::orderBy('nama')->get();

        $pegawaisSimgos = [];
        if (class_exists(PegawaiSimgos::class) && (bool) env('SECOND_DB_DATABASE')) {
            try {
                $pegawaisSimgos = PegawaiSimgos::orderBy('NAMA')->limit(200)->get();
            } catch (\Exception $e) {
                $pegawaisSimgos = [];
            }
        }

        return view('users.edit', compact('user', 'pegawais', 'pegawaisSimgos'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'pegawai_ref' => 'nullable|string',
            'is_admin' => 'sometimes|boolean',
        ]);

        // Resolve pegawai_ref similar to store
        $pegawaiId = $user->pegawai_id;
        if (!empty($data['pegawai_ref'])) {
            if (str_starts_with($data['pegawai_ref'], 'local-')) {
                $pegawaiId = intval(substr($data['pegawai_ref'], 6));
            } elseif (str_starts_with($data['pegawai_ref'], 'simgos-') && class_exists(PegawaiSimgos::class)) {
                $nip = substr($data['pegawai_ref'], 7);
                try {
                    $s = PegawaiSimgos::where('NIP', $nip)->first();
                    if ($s) {
                        $existing = Pegawai::where('nip', $s->NIP)->first();
                        if ($existing) {
                            $pegawaiId = $existing->id;
                        } else {
                            $toCreate = [
                                'nip' => $s->NIP,
                                'nama' => $s->NAMA,
                                'panggilan' => $s->PANGGILAN ?? null,
                                'gelar_depan' => $s->GELAR_DEPAN ?? null,
                                'gelar_belakang' => $s->GELAR_BELAKANG ?? null,
                                'tempat_lahir' => $s->TEMPAT_LAHIR ?? null,
                                'tanggal_lahir' => isset($s->TANGGAL_LAHIR) && $s->TANGGAL_LAHIR ? $s->TANGGAL_LAHIR->format('Y-m-d') : null,
                                'agama' => $s->AGAMA ?? null,
                                'jenis_kelamin' => $s->JENIS_KELAMIN ?? null,
                                'profesi' => $s->PROFESI ?? null,
                                'smf' => $s->SMF ?? null,
                                'alamat' => $s->ALAMAT ?? null,
                                'rt' => $s->RT ?? null,
                                'rw' => $s->RW ?? null,
                                'kodepos' => $s->KODEPOS ?? null,
                                'wilayah' => $s->WILAYAH ?? null,
                                'email' => $s->EMAIL ?? null,
                                'tanggal' => $s->TANGGAL ?? null,
                                'non_pegawai' => $s->NON_PEGAWAI ?? null,
                                'status' => $s->STATUS ?? null,
                            ];
                            $created = Pegawai::create($toCreate);
                            $pegawaiId = $created->id ?? $pegawaiId;
                        }
                    }
                } catch (\Exception $e) {
                    // ignore
                }
            }
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->pegawai_id = $pegawaiId ?? null;
        $user->is_admin = isset($data['is_admin']) ? (bool)$data['is_admin'] : false;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // prevent deleting yourself accidentally
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
