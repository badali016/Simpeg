<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawais = Pegawai::with('jabatan')->orderBy('created_at', 'desc')->paginate(10);
        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        return view('pegawai.create', compact('jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:pegawais,nip',
            'jabatan_id' => 'required|exists:jabatans,id',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:30',
        ]);

        Pegawai::create($data);

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::with('jabatan')->findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        return view('pegawai.edit', compact('pegawai', 'jabatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $data = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:pegawais,nip,' . $pegawai->id,
            'jabatan_id' => 'required|exists:jabatans,id',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:30',
        ]);

        $pegawai->update($data);

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}
