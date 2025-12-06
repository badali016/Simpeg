@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<!-- Welcome Header -->
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-2">Portal Pegawai</h1>
    <p class="text-sm sm:text-base text-slate-600">Selamat datang, <span class="font-semibold text-slate-900">{{ $pegawai->nama ?? 'Pegawai' }}</span></p>
</div>

<!-- Main Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    
    <!-- Profil Card -->
    <div class="md:col-span-2 lg:col-span-1 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 text-white border-2 border-blue-500">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1 min-w-0">
                <div class="flex items-center mb-2 md:mb-3">
                    <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <h3 class="text-lg md:text-xl font-bold text-white">Profil</h3>
                </div>
                <p class="text-xl sm:text-2xl md:text-3xl font-extrabold mb-2 text-white drop-shadow-md truncate">{{ $pegawai->nama ?? '-' }}</p>
                <p class="text-white font-semibold text-sm md:text-base mb-1">NIP: {{ $pegawai->nip ?? '-' }}</p>
                @if($pegawai->jabatan ?? false)
                    <p class="text-blue-100 font-medium text-xs md:text-sm bg-blue-800/40 inline-block px-2 md:px-3 py-1 rounded-full">{{ $pegawai->jabatan->nama ?? '-' }}</p>
                @endif
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 bg-white/30 rounded-xl md:rounded-2xl flex items-center justify-center backdrop-blur-sm shadow-lg flex-shrink-0">
                <svg class="w-10 h-10 md:w-12 md:h-12 text-white drop-shadow" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
        <div class="flex gap-2 mt-4 md:mt-6">
            <a href="{{ route('pegawai.profile') }}" class="flex-1 px-3 md:px-4 py-2.5 min-h-[44px] flex items-center justify-center bg-white/25 hover:bg-white/35 rounded-lg text-center text-xs md:text-sm font-bold transition backdrop-blur-sm text-white shadow-md border border-white/30">
                Lihat Profil
            </a>
            <a href="{{ route('pegawai.profile.edit') }}" class="flex-1 px-3 md:px-4 py-2.5 min-h-[44px] flex items-center justify-center bg-white hover:bg-white/90 text-blue-600 rounded-lg text-center text-xs md:text-sm font-bold transition shadow-md">
                Ubah Kontak
            </a>
        </div>
    </div>

    <!-- Presensi Card -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 border-2 border-slate-300">
        <div class="flex items-center justify-between mb-4 md:mb-5">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-600 rounded-lg md:rounded-xl flex items-center justify-center mr-2 md:mr-3 shadow-md">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-base md:text-xl font-bold text-slate-900">Presensi Terakhir</h3>
            </div>
        </div>

        <div class="space-y-3 mb-5">
            @if($attendances->isEmpty())
                <div class="text-center py-8 bg-slate-50 rounded-xl border-2 border-dashed border-slate-300">
                    <svg class="w-16 h-16 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-slate-600 text-sm md:text-base font-semibold">Belum ada data presensi</p>
                </div>
            @else
                @foreach($attendances->take(3) as $a)
                    @php $badge = $a->type === 'in' ? 'bg-emerald-600' : 'bg-red-600'; @endphp
                    <div class="flex items-center justify-between gap-2 p-3 md:p-4 bg-slate-50 rounded-xl border-2 border-slate-200 hover:shadow-lg hover:border-slate-300 transition">
                        <div class="flex items-center min-w-0 flex-1">
                            <span class="px-2 md:px-4 py-1.5 md:py-2 rounded-lg md:rounded-xl text-xs md:text-sm font-bold {{ $badge }} text-white mr-2 md:mr-4 shadow-md whitespace-nowrap">
                                {{ $a->type === 'in' ? '🟢 IN' : '🔴 OUT' }}
                            </span>
                            <div class="min-w-0">
                                <div class="text-sm md:text-base font-bold text-slate-900 truncate">{{ \Illuminate\Support\Carbon::parse($a->recorded_at)->format('d M Y') }}</div>
                                <div class="text-xs md:text-sm text-slate-600 font-medium">{{ \Illuminate\Support\Carbon::parse($a->recorded_at)->format('H:i') }} WIB</div>
                            </div>
                        </div>
                        @if(isset($a->geofence_ok))
                            <span class="hidden sm:inline-block px-2 md:px-3 py-1.5 md:py-2 rounded-lg text-xs md:text-sm font-bold {{ $a->geofence_ok ? 'bg-emerald-100 text-emerald-800 border-2 border-emerald-300' : 'bg-red-100 text-red-800 border-2 border-red-300' }} whitespace-nowrap">
                                {{ $a->geofence_ok ? '📍 On-site' : '📍 Off-site' }}
                            </span>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

        @php
            $last = $attendances->first();
            $nextType = ($last && $last->type === 'in') ? 'out' : 'in';
            $btnText = $nextType === 'in' ? 'Clock In' : 'Clock Out';
            $btnTextColor = $nextType === 'in' ? 'text-emerald-700' : 'text-red-700';
        @endphp
        <div class="flex gap-2">
            <a href="{{ route('pegawai.attendance.form') }}" class="flex-1 px-3 md:px-4 py-2.5 min-h-[44px] flex items-center justify-center bg-white hover:bg-slate-50 {{ $btnTextColor }} rounded-lg text-center text-xs md:text-sm font-bold shadow-md transition hover:scale-105 border-2 {{ $nextType === 'in' ? 'border-emerald-500' : 'border-red-500' }}">
                {{ $btnText }}
            </a>
            <a href="{{ route('pegawai.attendance.form') }}" class="px-3 md:px-4 py-2.5 min-h-[44px] flex items-center justify-center bg-white hover:bg-slate-50 text-slate-700 rounded-lg text-xs md:text-sm font-bold transition shadow-md border-2 border-slate-400">
                Riwayat
            </a>
        </div>
    </div>

    <!-- Pengajuan Card -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 border-2 border-slate-300">
        <div class="flex items-center justify-between mb-4 md:mb-5">
            <div class="flex items-center">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-600 rounded-lg md:rounded-xl flex items-center justify-center mr-2 md:mr-3 shadow-md">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-base md:text-xl font-bold text-slate-900">Pengajuan</h3>
            </div>
        </div>

        @php
            $leavesCol = collect($leaves);
            $approvedCount = $leavesCol->where('status', 'approved')->count();
            $pendingCount = $leavesCol->where('status', 'pending')->count();
            $rejectedCount = $leavesCol->where('status', 'rejected')->count();
        @endphp

        <div class="grid grid-cols-3 gap-2 md:gap-3 mb-4 md:mb-5">
            <div class="bg-emerald-100 rounded-lg md:rounded-xl p-3 md:p-4 border-2 border-emerald-400 shadow-md">
                <div class="text-xl sm:text-2xl md:text-3xl font-extrabold text-emerald-700">{{ $approvedCount }}</div>
                <div class="text-xs text-emerald-800 font-bold">Approved</div>
            </div>
            <div class="bg-yellow-100 rounded-lg md:rounded-xl p-3 md:p-4 border-2 border-yellow-400 shadow-md">
                <div class="text-xl sm:text-2xl md:text-3xl font-extrabold text-yellow-700">{{ $pendingCount }}</div>
                <div class="text-xs text-yellow-800 font-bold">Pending</div>
            </div>
            <div class="bg-red-100 rounded-lg md:rounded-xl p-3 md:p-4 border-2 border-red-400 shadow-md">
                <div class="text-xl sm:text-2xl md:text-3xl font-extrabold text-red-700">{{ $rejectedCount }}</div>
                <div class="text-xs text-red-800 font-bold">Rejected</div>
            </div>
        </div>

        <div class="space-y-3 mb-5">
            @if($leavesCol->isEmpty())
                <div class="text-center py-8 bg-slate-50 rounded-xl border-2 border-dashed border-slate-300">
                    <svg class="w-16 h-16 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-slate-600 text-base font-semibold">Belum ada pengajuan</p>
                </div>
            @else
                @foreach($leavesCol->take(2) as $l)
                    <div class="p-3 md:p-4 bg-slate-50 rounded-xl border-2 border-slate-200 hover:shadow-lg hover:border-slate-300 transition">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <div class="font-bold text-slate-900 text-sm md:text-base truncate flex-1">{{ ucfirst($l->type) }}</div>
                            @php $s = $l->status; @endphp
                            <span class="px-2 md:px-3 py-1 md:py-1.5 rounded-lg text-xs md:text-sm font-bold shadow-md whitespace-nowrap {{ $s === 'approved' ? 'bg-emerald-600 text-white' : ($s === 'rejected' ? 'bg-red-600 text-white' : 'bg-yellow-500 text-white') }}">
                                {{ ucfirst($s) }}
                            </span>
                        </div>
                        <div class="text-xs md:text-sm text-slate-600 font-medium">
                            {{ \Illuminate\Support\Carbon::parse($l->starts_at)->format('d M') }} - {{ \Illuminate\Support\Carbon::parse($l->ends_at)->format('d M Y') }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="flex gap-2">
            <a href="{{ route('pegawai.leave.create') }}" class="flex-1 px-3 md:px-4 py-2.5 min-h-[44px] flex items-center justify-center bg-white hover:bg-slate-50 text-emerald-700 rounded-lg text-center text-xs md:text-sm font-bold shadow-md transition hover:scale-105 border-2 border-emerald-500">
                <span class="hidden sm:inline">Ajukan Cuti / Izin</span>
                <span class="sm:hidden">Ajukan</span>
            </a>
            <a href="{{ route('pegawai.leaves.index') }}" class="px-3 md:px-4 py-2.5 min-h-[44px] flex items-center justify-center bg-white hover:bg-slate-50 text-slate-700 rounded-lg text-xs md:text-sm font-bold transition shadow-md border-2 border-slate-400 whitespace-nowrap">
                Lihat Semua
            </a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 border-2 border-slate-300">
    <div class="flex items-center mb-4 md:mb-6">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-600 rounded-lg md:rounded-xl flex items-center justify-center mr-2 md:mr-3 shadow-md">
            <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h3 class="text-base md:text-xl font-bold text-slate-900">Aksi Cepat</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4">
        <a href="{{ route('pegawai.attendance.form') }}" class="group flex items-center p-4 md:p-5 bg-white hover:bg-slate-50 rounded-xl border-2 border-indigo-400 transition hover:scale-105 hover:shadow-2xl shadow-lg min-h-[80px]">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-indigo-600 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0">
                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="font-bold text-indigo-700 text-sm md:text-base">Presensi</div>
                <div class="text-xs md:text-sm text-slate-600 font-medium">Clock-in/out</div>
            </div>
        </a>

        <a href="{{ route('pegawai.leave.create') }}" class="group flex items-center p-4 md:p-5 bg-white hover:bg-slate-50 rounded-xl border-2 border-emerald-400 transition hover:scale-105 hover:shadow-2xl shadow-lg min-h-[80px]">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-emerald-600 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0">
                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="font-bold text-emerald-700 text-sm md:text-base">Ajukan Cuti / Izin</div>
                <div class="text-xs md:text-sm text-slate-600 font-medium">Buat pengajuan baru</div>
            </div>
        </a>

        <a href="{{ route('pegawai.profile') }}" class="group flex items-center p-4 md:p-5 bg-white hover:bg-slate-50 rounded-xl border-2 border-slate-400 transition hover:scale-105 hover:shadow-2xl shadow-lg min-h-[80px]">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-slate-600 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0">
                <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="font-bold text-slate-700 text-sm md:text-base">Lihat Profil</div>
                <div class="text-xs md:text-sm text-slate-600 font-medium">Info lengkap</div>
            </div>
        </a>
    </div>
</div>

@endsection
