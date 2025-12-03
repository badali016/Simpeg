@extends('layouts.app')

@section('content')
    @include('components.neon-styles')
    <div class="max-w-2xl mx-auto neon-card">
        @php
            $isSimgos = is_object($pegawai) && ($pegawai->is_simgos ?? false);
            $pegawaiKey = (is_object($pegawai) && isset($pegawai->id)) ? $pegawai->id : (method_exists($pegawai, 'getKey') ? $pegawai->getKey() : $pegawai);
        @endphp
        <div class="flex items-start justify-between mb-4">
            <h2 class="text-xl font-semibold">Detail Pegawai</h2>
            <div class="space-x-2">
                @if($isSimgos)
                        <form action="{{ route('admin.pegawai.import', $pegawaiKey) }}" method="POST" class="inline">
                        @csrf
                        <button class="inline-flex px-3 py-1.5 bg-green-600 text-white rounded">Import</button>
                    </form>
                @else
                        <a href="{{ route('admin.pegawai.edit', $pegawaiKey) }}" class="inline-flex px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded">Edit</a>
                @endif
                    <a href="{{ route('admin.pegawai.index') }}" class="inline-flex px-3 py-1.5 text-blue-200 hover:underline">Kembali</a>
            </div>
        </div>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm text-gray-700">
            <div>
                <dt class="font-medium text-gray-600">ID</dt>
                <dd>{{ $pegawai->id }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Nama Pegawai</dt>
                <dd>{{ $pegawai->nama ?? $pegawai->nama_pegawai ?? $pegawai->NAMA ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">NIP</dt>
                <dd>{{ $pegawai->nip }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Jabatan</dt>
                <dd>{{ $pegawai->profesi_nama ?? ($pegawai->profesi ?? (optional($pegawai->jabatan)->nama_jabatan ?? '-')) }}</dd>
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
