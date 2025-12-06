@extends('layouts.app')

@section('content')
    @include('components.neon-styles')
    
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4 md:mb-6">
        <h2 class="text-xl md:text-2xl font-semibold text-slate-900">Daftar Jabatan</h2>
        <a href="{{ route('admin.jabatan.create') }}" class="inline-flex items-center px-3 md:px-4 py-2.5 min-h-[44px] bg-indigo-600 hover:bg-indigo-700 text-white rounded shadow-md transition text-sm whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="hidden sm:inline">Tambah Jabatan</span>
            <span class="sm:hidden">Tambah</span>
        </a>
    </div>

    <div class="card overflow-hidden">
        @if($jabatans->count())
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider whitespace-nowrap">ID</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider whitespace-nowrap">Nama Jabatan</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider whitespace-nowrap">Kode</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">Eselon</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">Unit Kerja</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="px-3 md:px-6 py-2 md:py-3 text-right text-xs font-medium text-slate-600 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-transparent">
                        @foreach($jabatans as $jabatan)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-3 md:px-6 py-3 md:py-4 text-xs md:text-sm text-slate-700 whitespace-nowrap">{{ $jabatan->id }}</td>
                            <td class="px-3 md:px-6 py-3 md:py-4 text-xs md:text-sm font-medium text-slate-900 whitespace-nowrap">
                                <a href="{{ route('admin.jabatan.show', $jabatan) }}" class="hover:text-blue-600 hover:underline">{{ $jabatan->nama_jabatan }}</a>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 text-xs md:text-sm text-slate-700 whitespace-nowrap">{{ $jabatan->kode_jabatan }}</td>
                            <td class="px-3 md:px-6 py-3 md:py-4 text-xs md:text-sm text-slate-700 whitespace-nowrap hidden lg:table-cell">{{ $jabatan->eselon }}</td>
                            <td class="px-3 md:px-6 py-3 md:py-4 text-xs md:text-sm text-slate-700 whitespace-nowrap hidden lg:table-cell">{{ $jabatan->unit_kerja }}</td>
                            <td class="px-3 md:px-6 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $jabatan->status == 'Aktif' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $jabatan->status }}
                                </span>
                            </td>
                            <td class="px-3 md:px-6 py-3 md:py-4 text-right text-xs whitespace-nowrap">
                                <a href="{{ route('admin.jabatan.edit', $jabatan) }}" class="text-indigo-600 hover:text-indigo-800 hover:underline mr-2 md:mr-3">Edit</a>
                                <form action="{{ route('admin.jabatan.destroy', $jabatan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus jabatan ini?')" class="text-red-600 hover:text-red-800 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-200 bg-transparent">
                {{ $jabatans->links() }} 
            </div>
        @else
            <div class="p-6 text-center text-slate-600">Tidak ada data jabatan.</div>
        @endif
    </div>

@endsection