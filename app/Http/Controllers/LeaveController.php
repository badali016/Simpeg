<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LeaveRequest;

class LeaveController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;
        return view('pegawai_portal.leave_create', compact('pegawai'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;
        if (! $pegawai) abort(403);

        $query = LeaveRequest::where('pegawai_id', $pegawai->id)->orderBy('starts_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $leaves = $query->paginate(12)->withQueryString();

        return view('pegawai.leaves.index', compact('leaves'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;
        if (! $pegawai) abort(403);

        $data = $request->validate([
            'type' => 'required|in:cuti,izin,sakit,dinas_luar',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'reason' => 'nullable|string',
            'proof' => 'nullable|file|max:10240',
        ]);

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('leave_proofs');
        }

        LeaveRequest::create([
            'pegawai_id' => $pegawai->id,
            'type' => $data['type'],
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'reason' => $data['reason'] ?? null,
            'proof_path' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->route('pegawai.portal')->with('success', 'Pengajuan cuti/izin berhasil dikirim.');
    }
}
