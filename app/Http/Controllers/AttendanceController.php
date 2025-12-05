<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;
        if (! $pegawai) {
            abort(403);
        }

        $data = $request->validate([
            'type' => 'required|in:in,out',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'geofence_ok' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        // Server-side geofence check
        $officeLat = env('GEOFENCE_LAT');
        $officeLng = env('GEOFENCE_LNG');
        $radiusMeters = (int) env('GEOFENCE_RADIUS_METERS', 100);
        $enforce = env('GEOFENCE_ENFORCE', false);

        $latitude = isset($data['latitude']) ? (float)$data['latitude'] : null;
        $longitude = isset($data['longitude']) ? (float)$data['longitude'] : null;

        $geofenceOk = false;
        if ($latitude !== null && $longitude !== null && $officeLat && $officeLng) {
            // haversine distance in meters
            $latFrom = deg2rad($latitude);
            $lonFrom = deg2rad($longitude);
            $latTo = deg2rad((float)$officeLat);
            $lonTo = deg2rad((float)$officeLng);
            $dLat = $latTo - $latFrom;
            $dLon = $lonTo - $lonFrom;
            $a = sin($dLat/2) * sin($dLat/2) + cos($latFrom) * cos($latTo) * sin($dLon/2) * sin($dLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distance = 6371000 * $c;
            $geofenceOk = $distance <= $radiusMeters;
        }

        if ($enforce && ! $geofenceOk) {
            return redirect()->back()->withInput()->with('error', 'Anda berada di luar area kerja. Presensi diblokir.');
        }

        $attendance = Attendance::create([
            'pegawai_id' => $pegawai->id,
            'type' => $data['type'],
            'latitude' => $latitude,
            'longitude' => $longitude,
            'geofence_ok' => $geofenceOk ? 1 : 0,
            'notes' => $data['notes'] ?? null,
            'recorded_at' => now(),
        ]);

        $msg = 'Presensi tercatat.' . ($geofenceOk ? '' : ' (Diluar area kerja)');
        return redirect()->route('pegawai.portal')->with('success', $msg);
    }

    // Show attendance form
    public function showForm()
    {
        $user = auth()->user();
        $pegawai = $user->pegawai;
        if (! $pegawai) abort(403);
        return view('pegawai_portal.attendance_form', compact('pegawai'));
    }

    public function requestCorrection(Request $request)
    {
        // Minimal placeholder: record a correction request as an attendance with notes
        $user = Auth::user();
        $pegawai = $user->pegawai;
        if (! $pegawai) {
            abort(403);
        }

        $data = $request->validate([
            'original_attendance_id' => 'nullable|integer',
            'requested_time' => 'required|date',
            'reason' => 'nullable|string',
        ]);

        // For now store as attendance record with notes and flag geofence_ok=false; admin reviews later
        Attendance::create([
            'pegawai_id' => $pegawai->id,
            'type' => 'in',
            'latitude' => null,
            'longitude' => null,
            'geofence_ok' => false,
            'notes' => 'Koreksi presensi: ' . ($data['reason'] ?? '') . ' | requested_time=' . $data['requested_time'],
            'recorded_at' => $data['requested_time'],
        ]);

        return redirect()->route('pegawai.portal')->with('success', 'Permintaan koreksi presensi dikirim.');
    }
}
