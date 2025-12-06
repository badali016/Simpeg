@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<h2 class="text-xl md:text-2xl text-white mb-2">Profil Saya</h2>
<div class="card p-4 md:p-6">
    <div class="space-y-3 text-sm md:text-base">
        <p><strong class="text-slate-900">Nama:</strong> <span class="text-slate-700">{{ $pegawai->nama }}</span></p>
        <p><strong class="text-slate-900">NIP:</strong> <span class="text-slate-700">{{ $pegawai->nip }}</span></p>
        <p><strong class="text-slate-900">Email:</strong> <span class="text-slate-700">{{ $pegawai->email ?? '-' }}</span></p>
        <p><strong class="text-slate-900">Alamat:</strong> <span class="text-slate-700">{{ $pegawai->alamat ?? '-' }}</span></p>
    </div>
    <a href="{{ route('pegawai.profile.edit') }}" class="inline-block mt-4 px-4 py-2.5 min-h-[44px] bg-yellow-400 hover:bg-yellow-500 text-black rounded font-semibold text-sm">Ubah Kontak</a>
</div>

@endsection
