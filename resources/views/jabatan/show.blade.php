@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <div class="flex items-start justify-between mb-4">
            <h2 class="text-xl font-semibold">Detail Jabatan</h2>
            <div class="space-x-2">
                <a href="{{ route('jabatan.edit', $jabatan) }}" class="inline-flex px-3 py-1.5 bg-yellow-100 text-yellow-800 rounded">Edit</a>
                <a href="{{ route('jabatan.index') }}" class="inline-flex px-3 py-1.5 text-gray-600 hover:underline">Kembali</a>
            </div>
        </div>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm text-gray-700">
            <div>
                <dt class="font-medium text-gray-600">ID</dt>
                <dd>{{ $jabatan->id }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Nama Jabatan</dt>
                <dd>{{ $jabatan->nama_jabatan }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Kode Jabatan</dt>
                <dd>{{ $jabatan->kode_jabatan }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Eselon</dt>
                <dd>{{ $jabatan->eselon }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Unit Kerja</dt>
                <dd>{{ $jabatan->unit_kerja }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Status</dt>
                <dd>{{ $jabatan->status }}</dd>
            </div>
        </dl>
    </div>
@endsection
