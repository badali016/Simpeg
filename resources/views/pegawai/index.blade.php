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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pegawais as $index => $pegawai)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $pegawais->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $pegawai->nip }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                @php
                                    $pegawaiKey = (is_object($pegawai) && isset($pegawai->id)) ? $pegawai->id : (method_exists($pegawai, 'getKey') ? $pegawai->getKey() : $pegawai);
                                    $displayName = $pegawai->nama ?? $pegawai->simgos_nama ?? $pegawai->NAMA ?? '-';
                                @endphp
                                <a href="{{ route('pegawai.show', $pegawaiKey) }}" class="hover:underline">{{ $displayName }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $pegawai->agama_nama ?? $pegawai->simgos_agama_nama ?? ($pegawai->agama ?? '-') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $pegawai->jenis_kelamin_nama ?? $pegawai->simgos_jenis_kelamin_nama ?? ($pegawai->jenis_kelamin ?? '-') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ \Illuminate\Support\Str::limit($pegawai->alamat ?? ($pegawai->simgos_alamat ?? '-'), 60) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @php $isSimgos = is_object($pegawai) && ($pegawai->is_simgos ?? false); @endphp
                                    @php
                                        $jabLabel = $pegawai->profesi_nama ?? $pegawai->simgos_profesi_nama ?? ($pegawai->profesi ?? null);
                                        if (!$jabLabel) {
                                            $jabLabel = $pegawai->simgos_jabatan_name ?? optional($pegawai->jabatan)->nama_jabatan ?? '-';
                                        }
                                    @endphp
                                    {{ $jabLabel }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @php
                                        $st = $pegawai->status ?? $pegawai->simgos_status ?? $pegawai->STATUS ?? null;
                                        $statusLabel = is_null($st) ? '-' : (is_numeric($st) ? ($st ? 'Aktif' : 'Tidak Aktif') : $st);
                                    @endphp
                                    {{ $statusLabel }}
                                </td>
                            <td class="px-6 py-4 text-right text-sm">
                                @php
                                    $isSimgos = is_object($pegawai) && ($pegawai->is_simgos ?? false);
                                @endphp

                                @if($isSimgos)
                                    <form action="{{ route('pegawai.import', $pegawaiKey) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Import</button>
                                    </form>
                                @else
                                    <a href="{{ route('pegawai.edit', $pegawaiKey) }}" class="text-yellow-600 hover:underline mr-3">Edit</a>
                                    <form action="{{ route('pegawai.destroy', $pegawaiKey) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus pegawai ini?')" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-white border-t border-gray-100">
                {{ $pegawais->withQueryString()->links() }}
            </div>
        @else
            <div class="p-6 text-center text-gray-600">Tidak ada data pegawai.</div>
        @endif
    </div>

@endsection
