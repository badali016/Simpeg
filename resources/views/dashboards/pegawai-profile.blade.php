@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <div class="flex items-start justify-between mb-4">
            <h2 class="text-xl font-semibold">Profil Pegawai</h2>
            <a href="{{ route('pegawai.dashboard') }}" class="inline-flex px-3 py-1.5 text-gray-600 hover:underline">Kembali</a>
        </div>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm text-gray-700">
            <div>
                <dt class="font-medium text-gray-600">Nama</dt>
                <dd>{{ $pegawai->nama_pegawai }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">NIP</dt>
                <dd>{{ $pegawai->nip }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Jabatan</dt>
                <dd>{{ $pegawai->jabatan?->nama_jabatan ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Email</dt>
                <dd>{{ $pegawai->email ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">No. Telepon</dt>
                <dd>{{ $pegawai->no_telepon ?? '-' }}</dd>
            </div>
        </dl>
    </div>

@endsection
