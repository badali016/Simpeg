@extends('layouts.app')

@section('content')
    @include('components.neon-styles')
    
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-white">Daftar Jabatan</h2>
        <a href="{{ route('admin.jabatan.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded shadow hover:shadow-lg hover:shadow-cyan-500/30 transition">Tambah Jabatan</a>
    </div>

    <div class="card overflow-hidden">
        @if($jabatans->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-slate-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">Nama Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">Eselon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">Unit Kerja</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-blue-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 bg-transparent">
                        @foreach($jabatans as $jabatan)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4 text-sm text-slate-400">{{ $jabatan->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-white">
                                <a href="{{ route('admin.jabatan.show', $jabatan) }}" class="hover:text-blue-400 hover:underline">{{ $jabatan->nama_jabatan }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-300">{{ $jabatan->kode_jabatan }}</td>
                            <td class="px-6 py-4 text-sm text-slate-300">{{ $jabatan->eselon }}</td>
                            <td class="px-6 py-4 text-sm text-slate-300">{{ $jabatan->unit_kerja }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded text-xs {{ $jabatan->status == 'Aktif' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $jabatan->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('admin.jabatan.edit', $jabatan) }}" class="text-yellow-400 hover:text-yellow-300 hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.jabatan.destroy', $jabatan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus jabatan ini?')" class="text-red-400 hover:text-red-300 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-white/10 bg-transparent">
                {{ $jabatans->links() }} 
            </div>
        @else
            <div class="p-6 text-center text-slate-400">Tidak ada data jabatan.</div>
        @endif
    </div>

@endsection