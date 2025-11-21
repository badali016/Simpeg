@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-sm text-gray-500">Total Pegawai</div>
            <div class="text-3xl font-semibold mt-2">{{ $totalPegawai }}</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-sm text-gray-500">Total Jabatan</div>
            <div class="text-3xl font-semibold mt-2">{{ $totalJabatan }}</div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="text-sm text-gray-500">Quick Actions</div>
            <div class="mt-3 space-x-2">
                <a href="{{ route('pegawai.create') }}" class="inline-flex px-3 py-2 bg-[#f53003] text-white rounded">Tambah Pegawai</a>
                <a href="{{ route('jabatan.create') }}" class="inline-flex px-3 py-2 bg-gray-100 text-gray-800 rounded">Tambah Jabatan</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold">Pegawai Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentPegawais as $p)
                    @php
                        // determine key and display name to work with both Eloquent models and stdClass SIMGOS records
                        if (is_object($p)) {
                            $pKey = $p->id ?? ($p->ID ?? (method_exists($p, 'getKey') ? $p->getKey() : null));
                            $pName = $p->nama ?? $p->nama_pegawai ?? $p->NAMA ?? '-';
                            $pJabatan = $p->profesi_nama ?? ($p->profesi ?? ($p->jabatan?->nama_jabatan ?? ($p->jabatan_nama ?? '-')));
                        } else {
                            $pKey = $p;
                            $pName = '-';
                            $pJabatan = '-';
                        }
                    @endphp
                    <tr>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('pegawai.show', $pKey) }}" class="font-medium text-[#1b1b18] hover:underline">{{ $pName }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->nip ?? ($p->NIP ?? '-') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pJabatan }}</td>
                        @php
                            $pStatusVal = $p->status ?? $p->STATUS ?? null;
                            $pStatusLabel = is_null($pStatusVal) ? '-' : (is_numeric($pStatusVal) ? ($pStatusVal ? 'Aktif' : 'Tidak Aktif') : $pStatusVal);
                        @endphp
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pStatusLabel }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            @php $isSimgos = is_object($p) && ($p->is_simgos ?? false); @endphp
                            @if($isSimgos)
                                <form action="{{ route('pegawai.import', $pKey) }}" method="POST">
                                    @csrf
                                    <button class="px-2 py-1 bg-green-600 text-white rounded">Import</button>
                                </form>
                            @else
                                <a href="{{ route('pegawai.edit', $pKey) }}" class="text-yellow-600 hover:underline">Edit</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-600" colspan="4">Belum ada data pegawai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
