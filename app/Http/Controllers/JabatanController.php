<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $jabatans = Jabatan::orderBy('created_at', 'desc')->paginate(10);
    return view('jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'kode_jabatan' => 'required|string|max:100|unique:jabatans,kode_jabatan',
            'eselon' => 'nullable|string|max:100',
            'unit_kerja' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        Jabatan::create($data);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('jabatan.show', compact('jabatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $data = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'kode_jabatan' => 'required|string|max:100|unique:jabatans,kode_jabatan,' . $jabatan->id,
            'eselon' => 'nullable|string|max:100',
            'unit_kerja' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
        ]);

        $jabatan->update($data);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}
