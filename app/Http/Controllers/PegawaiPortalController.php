<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pegawai;
use App\Models\Attendance;
use App\Models\LeaveRequest;

class PegawaiPortalController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai()->with('jabatan')->first();

        // recent attendances and leaves
        $attendances = Attendance::where('pegawai_id', $pegawai->id)->latest()->take(10)->get();
        $leaves = LeaveRequest::where('pegawai_id', $pegawai->id)->latest()->take(5)->get();

        return view('dashboards.pegawai-home', compact('pegawai', 'attendances', 'leaves'));
    }

    public function profile()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai()->with('jabatan')->first();
        return view('pegawai_portal.profile', compact('pegawai'));
    }

    public function editContact()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai()->first();
        return view('pegawai_portal.edit_contact', compact('pegawai'));
    }

    public function updateContact(Request $request)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai()->first();

        $data = $request->validate([
            'email' => 'nullable|email',
            'alamat' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        // map to pegawai fields (email and alamat exist; phone might not)
        $pegawai->email = $data['email'] ?? $pegawai->email;
        $pegawai->alamat = $data['alamat'] ?? $pegawai->alamat;
        if (isset($data['phone'])) {
            $pegawai->phone = $data['phone'];
        }
        $pegawai->save();

        return redirect()->route('pegawai.dashboard')->with('success', 'Kontak berhasil diperbarui.');
    }
}
