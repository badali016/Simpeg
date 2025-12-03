@extends('layouts.app')

@section('content')
    @include('components.neon-styles') <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="card p-6">
            <div class="text-sm text-slate-400">Total Pegawai</div>
            <div class="text-3xl font-semibold mt-2 text-white">{{ $totalPegawai }}</div>
        </div>
        <div class="card p-6">
            <div class="text-sm text-slate-400">Total Jabatan</div>
            <div class="text-3xl font-semibold mt-2 text-white">{{ $totalJabatan }}</div>
        </div>
        <div class="card p-6">
            <div class="text-sm text-slate-400">Quick Actions</div>
            <div class="mt-3 space-x-2">
                <a href="{{ route('admin.pegawai.create') }}" class="inline-flex px-3 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white rounded shadow-lg shadow-blue-500/30 transition">Tambah Pegawai</a>
                <a href="{{ route('admin.jabatan.create') }}" class="inline-flex px-3 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded shadow-lg shadow-indigo-500/30 transition">Tambah Jabatan</a>
            </div>
        </div>
    </div>

    <div class="card rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-white/10">
            <h3 class="text-lg font-semibold text-white">Pegawai Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-slate-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">NIP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10 bg-transparent">
                    @forelse($recentPegawais as $p)
                    @php
                        if (is_object($p)) {
                            $pKey = $p->id ?? ($p->ID ?? (method_exists($p, 'getKey') ? $p->getKey() : null));
                            $pName = $p->nama ?? $p->nama_pegawai ?? $p->NAMA ?? '-';
                            $pJabatan = $p->profesi_nama ?? ($p->profesi ?? ($p->jabatan?->nama_jabatan ?? ($p->jabatan_nama ?? '-')));
                        } else {
                            $pKey = $p; $pName = '-'; $pJabatan = '-';
                        }
                    @endphp
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.pegawai.show', $pKey) }}" class="font-medium text-white hover:text-blue-400 hover:underline">{{ $pName }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-300">{{ $p->nip ?? ($p->NIP ?? '-') }}</td>
                        <td class="px-6 py-4 text-sm text-slate-300">{{ $pJabatan }}</td>
                        @php
                            $pStatusVal = $p->status ?? $p->STATUS ?? null;
                            $pStatusLabel = is_null($pStatusVal) ? '-' : (is_numeric($pStatusVal) ? ($pStatusVal ? 'Aktif' : 'Tidak Aktif') : $pStatusVal);
                        @endphp
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs {{ $pStatusLabel == 'Aktif' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                {{ $pStatusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('admin.pegawai.edit', $pKey) }}" class="text-yellow-400 hover:text-yellow-300 hover:underline">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="px-6 py-4 text-sm text-slate-400 text-center" colspan="5">Belum ada data pegawai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection