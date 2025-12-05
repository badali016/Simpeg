@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<h2 class="text-2xl text-white mb-2">Profil Saya</h2>
<div class="card p-4">
    <p><strong>Nama:</strong> {{ $pegawai->nama }}</p>
    <p><strong>NIP:</strong> {{ $pegawai->nip }}</p>
    <p><strong>Email:</strong> {{ $pegawai->email ?? '-' }}</p>
    <p><strong>Alamat:</strong> {{ $pegawai->alamat ?? '-' }}</p>
    <a href="{{ route('pegawai.profile.edit') }}" class="inline-block mt-3 px-3 py-1 bg-yellow-400 text-black rounded">Ubah Kontak</a>
</div>

@endsection
