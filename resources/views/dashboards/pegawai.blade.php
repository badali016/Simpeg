@extends('layouts.app')

@section('content')
    @include('components.neon-styles')
    
    <div class="max-w-2xl mx-auto card p-6 rounded-lg shadow">
        <div class="flex items-start justify-between mb-6 border-b border-white/10 pb-4">
            <h2 class="text-xl font-semibold text-white">Profil Pegawai</h2>
            <a href="{{ route('pegawai.dashboard') }}" class="inline-flex px-3 py-1.5 text-slate-400 hover:text-white hover:bg-white/10 rounded transition">Kembali</a>
        </div>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
            <div>
                <dt class="font-medium text-blue-300 mb-1">Nama</dt>
                <dd class="text-white text-lg">{{ $pegawai->nama_pegawai }}</dd>
            </div>
            <div>
                <dt class="font-medium text-blue-300 mb-1">NIP</dt>
                <dd class="text-slate-300">{{ $pegawai->nip }}</dd>
            </div>
            <div>
                <dt class="font-medium text-blue-300 mb-1">Jabatan</dt>
                <dd class="text-slate-300">{{ $pegawai->jabatan?->nama_jabatan ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-medium text-blue-300 mb-1">Email</dt>
                <dd class="text-slate-300">{{ $pegawai->email ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-medium text-blue-300 mb-1">No. Telepon</dt>
                <dd class="text-slate-300">{{ $pegawai->no_telepon ?? '-' }}</dd>
            </div>
        </dl>
    </div>
@endsection