<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with('pegawai')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.leaves.index', compact('leaves'));
    }

    public function show($id)
    {
        $leave = LeaveRequest::with('pegawai')->findOrFail($id);
        return view('admin.leaves.show', compact('leave'));
    }

    public function approve(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->status = 'approved';
        $leave->save();
        return redirect()->route('admin.leaves.index')->with('success', 'Pengajuan disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->status = 'rejected';
        $leave->save();
        return redirect()->route('admin.leaves.index')->with('success', 'Pengajuan ditolak.');
    }
}
