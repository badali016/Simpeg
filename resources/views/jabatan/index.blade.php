@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold">Daftar Jabatan</h2>
        <a href="{{ route('jabatan.create') }}" class="inline-flex items-center px-4 py-2 bg-[#f53003] text-white rounded shadow hover:bg-[#d02403]">Tambah Jabatan</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($jabatans->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eselon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Kerja</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($jabatans as $jabatan)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $jabatan->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-[#1b1b18]"><a href="{{ route('jabatan.show', $jabatan) }}" class="hover:underline">{{ $jabatan->nama_jabatan }}</a></td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $jabatan->kode_jabatan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $jabatan->eselon }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $jabatan->unit_kerja }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $jabatan->status }}</td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('jabatan.edit', $jabatan) }}" class="text-[#f53003] hover:underline mr-3">Edit</a>
                                <form action="{{ route('jabatan.destroy', $jabatan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus jabatan ini?')" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-white border-t border-gray-100">
                {{ $jabatans->links() }}
            </div>
        @else
            <div class="p-6 text-center text-gray-600">Tidak ada data jabatan.</div>
        @endif
    </div>

@endsection
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    
</body>
</html>