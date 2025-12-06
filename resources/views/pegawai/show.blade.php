@extends('layouts.app')

@section('content')
    @include('components.neon-styles')
    <div class="max-w-2xl mx-auto neon-card px-4 sm:px-0">
        @php
            $isSimgos = is_object($pegawai) && ($pegawai->is_simgos ?? false);
            $pegawaiKey = (is_object($pegawai) && isset($pegawai->id)) ? $pegawai->id : (method_exists($pegawai, 'getKey') ? $pegawai->getKey() : $pegawai);
        @endphp
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4">
            <h2 class="text-lg md:text-xl font-semibold">Detail Pegawai</h2>
            <div class="flex gap-2 flex-wrap">
                @if($isSimgos)
                        <form action="{{ route('admin.pegawai.import', $pegawaiKey) }}" method="POST" class="inline">
                        @csrf
                        <button class="inline-flex px-3 py-2 min-h-[40px] items-center bg-green-600 text-white rounded text-sm">Import</button>
                    </form>
                @else
                        <a href="{{ route('admin.pegawai.edit', $pegawaiKey) }}" class="inline-flex px-3 py-2 min-h-[40px] items-center bg-yellow-100 text-yellow-800 rounded text-sm">Edit</a>
                @endif
                    <a href="{{ route('admin.pegawai.index') }}" class="inline-flex px-3 py-2 min-h-[40px] items-center text-blue-200 hover:underline text-sm">Kembali</a>
            </div>
        </div>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 md:gap-x-6 gap-y-3 text-xs md:text-sm text-gray-700">
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
