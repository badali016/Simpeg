<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        // list attendances that look like correction requests (notes contain 'Koreksi')
        $corrections = Attendance::where('notes', 'like', '%Koreksi%')->with('pegawai')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.attendance.index', compact('corrections'));
    }

    public function show($id)
    {
        $a = Attendance::with('pegawai')->findOrFail($id);
        return view('admin.attendance.show', compact('a'));
    }

    public function resolve(Request $request, $id)
    {
        $a = Attendance::findOrFail($id);
        $a->notes = ($a->notes ?? '') . "\n[admin-resolved] " . now();
        $a->save();
        return redirect()->route('admin.attendance.index')->with('success', 'Koreksi presensi ditandai selesai.');
    }
}
