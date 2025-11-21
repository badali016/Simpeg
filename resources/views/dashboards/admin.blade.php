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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentPegawais as $p)
                    <tr>
                        <td class="px-6 py-4 text-sm"><a href="{{ route('pegawai.show', $p) }}" class="font-medium text-[#1b1b18] hover:underline">{{ $p->nama_pegawai }}</a></td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->nip }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->jabatan?->nama_jabatan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->email ?? '-' }}</td>
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
