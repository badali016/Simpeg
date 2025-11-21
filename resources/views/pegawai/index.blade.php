@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Daftar Pegawai</h2>
        <a href="{{ route('pegawai.create') }}" class="inline-flex items-center px-4 py-2 bg-[#f53003] text-white rounded shadow hover:bg-[#d02403]">Tambah Pegawai</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($pegawais->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telp</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pegawais as $pegawai)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $pegawai->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-[#1b1b18]"><a href="{{ route('pegawai.show', $pegawai) }}" class="hover:underline">{{ $pegawai->nama_pegawai }}</a></td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pegawai->nip }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pegawai->jabatan?->nama_jabatan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pegawai->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pegawai->no_telepon ?? '-' }}</td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('pegawai.edit', $pegawai) }}" class="text-[#f53003] hover:underline mr-3">Edit</a>
                                <form action="{{ route('pegawai.destroy', $pegawai) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus pegawai ini?')" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-white border-t border-gray-100">
                {{ $pegawais->links() }}
            </div>
        @else
            <div class="p-6 text-center text-gray-600">Tidak ada data pegawai.</div>
        @endif
    </div>

@endsection
