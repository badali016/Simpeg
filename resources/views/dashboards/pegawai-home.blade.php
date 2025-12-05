@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<div class="mb-4">
    <h2 class="text-2xl text-white">Portal Pegawai</h2>
    <p class="text-sm text-blue-200">Ringkasan aktivitas dan akses cepat</p>
</div>

<div class="grid grid-cols-3 gap-4">
    <div class="card p-4">
        <h3 class="text-lg text-white">Profil</h3>
        <p class="text-sm text-blue-200">{{ $pegawai->nama ?? '-' }}</p>
        <div class="mt-2 space-x-2">
            <a href="{{ route('pegawai.profile') }}" class="inline-block text-blue-100">Lihat profil</a>
            <a href="{{ route('pegawai.profile.edit') }}" class="inline-block text-yellow-300">Ubah Kontak</a>
        </div>
    </div>

    <div class="card p-4">
        <h3 class="text-lg text-white">Presensi Terakhir</h3>
        <div class="text-sm text-blue-200">
            @if($attendances->isEmpty())
                <div class="text-blue-300">Belum ada data presensi.</div>
            @else
                <ul class="space-y-2">
                    @foreach($attendances as $a)
                        @php $badge = $a->type === 'in' ? 'bg-emerald-600' : 'bg-sky-600'; @endphp
                        <li class="flex justify-between items-center p-2 bg-slate-900/20 rounded">
                            <div>
                                <span class="px-2 py-1 mr-2 rounded text-xs {{ $badge }} text-white">{{ strtoupper($a->type) }}</span>
                                <span class="text-sm text-blue-200">{{ \Illuminate\Support\Carbon::parse($a->recorded_at)->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="text-xs text-slate-400">
                                @if(isset($a->geofence_ok) && $a->geofence_ok)
                                    <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-800">On-site</span>
                                @elseif(isset($a->geofence_ok))
                                    <span class="px-2 py-1 rounded bg-red-100 text-red-800">Off-site</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="mt-4">
            @php
                $last = $attendances->first();
                $nextType = ($last && $last->type === 'in') ? 'out' : 'in';
                $btnText = $nextType === 'in' ? 'Clock In' : 'Clock Out';
            @endphp
            <a href="{{ route('pegawai.attendance.form') }}" class="px-4 py-2 bg-indigo-600 text-white rounded shadow inline-block">{{ $btnText }}</a>
            <a href="{{ route('pegawai.attendance.form') }}" class="ml-3 px-3 py-2 bg-slate-700 text-white rounded">Riwayat Presensi</a>
        </div>
    </div>

    <div class="card p-4">
        <h3 class="text-lg text-white">Pengajuan</h3>
        @php
            $leavesCol = collect($leaves);
            $approvedCount = $leavesCol->where('status', 'approved')->count();
            $pendingCount = $leavesCol->where('status', 'pending')->count();
            $rejectedCount = $leavesCol->where('status', 'rejected')->count();
        @endphp

        <div class="flex items-center gap-3 mb-3">
            <div class="px-3 py-1 rounded bg-emerald-600 text-white text-sm">Approved: {{ $approvedCount }}</div>
            <div class="px-3 py-1 rounded bg-yellow-400 text-black text-sm">Pending: {{ $pendingCount }}</div>
            <div class="px-3 py-1 rounded bg-red-600 text-white text-sm">Rejected: {{ $rejectedCount }}</div>
        </div>

        <div class="space-y-2 text-sm text-blue-200">
            @if($leavesCol->isEmpty())
                <div class="text-sm text-blue-300">Belum ada pengajuan.</div>
            @else
                @foreach($leavesCol->take(3) as $l)
                    <div class="flex justify-between items-center p-2 bg-slate-900/30 rounded">
                        <div>
                            <div class="font-medium">{{ ucfirst($l->type) }}</div>
                            <div class="text-xs text-slate-400">{{ \Illuminate\Support\Carbon::parse($l->starts_at)->format('Y-m-d H:i') }} → {{ \Illuminate\Support\Carbon::parse($l->ends_at)->format('Y-m-d H:i') }}</div>
                        </div>
                        <div>
                            @php $s = $l->status; @endphp
                            <span class="px-2 py-1 rounded text-xs {{ $s === 'approved' ? 'bg-emerald-500 text-white' : ($s === 'rejected' ? 'bg-red-500 text-white' : 'bg-yellow-300 text-black') }}">{{ $s }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-3">
            <a href="{{ route('pegawai.leave.create') }}" class="inline-block px-3 py-2 bg-emerald-500 text-white rounded">Ajukan Cuti / Izin</a>
            <a href="{{ route('pegawai.leaves.index') }}" class="inline-block ml-2 px-3 py-2 bg-slate-700 text-white rounded">Lihat Semua</a>
        </div>
    </div>
</div>

<div class="mt-6">
    <h3 class="text-lg text-white mb-3">Aksi Cepat</h3>
    <div class="flex gap-3">
        <a href="{{ route('pegawai.attendance.form') }}" class="px-4 py-2 bg-indigo-600 text-white rounded shadow">Presensi (Clock-in/out)</a>
        <a href="{{ route('pegawai.leave.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded shadow">Ajukan Cuti / Izin</a>
        <a href="{{ route('pegawai.profile') }}" class="px-4 py-2 bg-slate-700 text-white rounded shadow">Lihat Profil</a>
    </div>
</div>

@endsection
