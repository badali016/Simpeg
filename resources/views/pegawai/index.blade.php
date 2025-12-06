@extends('layouts.app')

@section('content')
    @include('components.neon-styles')

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4">
        <div class="flex-1 min-w-0">
            <h2 class="text-xl md:text-2xl font-semibold text-slate-900">Daftar Pegawai</h2>
            <p class="text-xs md:text-sm text-slate-500">Menampilkan data pegawai — cocokkan dengan SIMGOS bila tersedia</p>
        </div>
        <a href="{{ route('admin.pegawai.create') }}" class="inline-flex items-center px-3 md:px-4 py-2.5 min-h-[44px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transition text-sm whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="hidden sm:inline">Tambah Pegawai</span>
            <span class="sm:hidden">Tambah</span>
        </a>
    </div>

    <div class="card overflow-hidden">
        @if($pegawais->count())
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Agama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach($pegawais as $index => $pegawai)
                        <tr class="hover:bg-slate-800/40">
                            <td class="px-6 py-4 text-sm text-blue-100">{{ $pegawais->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $pegawai->nip }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-800">
                                @php
                                    $pegawaiKey = (is_object($pegawai) && isset($pegawai->id)) ? $pegawai->id : (method_exists($pegawai, 'getKey') ? $pegawai->getKey() : $pegawai);
                                    $displayName = $pegawai->nama ?? $pegawai->simgos_nama ?? $pegawai->NAMA ?? '-';
                                @endphp
                                <a href="{{ route('admin.pegawai.show', $pegawaiKey) }}" class="hover:underline text-blue-600">{{ $displayName }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $pegawai->agama_nama ?? $pegawai->simgos_agama_nama ?? ($pegawai->agama ?? '-') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $pegawai->jenis_kelamin_nama ?? $pegawai->simgos_jenis_kelamin_nama ?? ($pegawai->jenis_kelamin ?? '-') }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ \Illuminate\Support\Str::limit($pegawai->alamat ?? ($pegawai->simgos_alamat ?? '-'), 60) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">
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
                                    <form action="{{ route('admin.pegawai.import', $pegawaiKey) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-emerald-500 hover:bg-emerald-400 text-white rounded-md text-sm font-medium shadow">Import</button>
                                    </form>
                                    <form action="{{ route('admin.pegawai.create_user') }}" method="POST" class="inline create-user-form">
                                        @csrf
                                        <input type="hidden" name="ref" value="simgos-{{ $pegawai->nip ?? $pegawai->NIP ?? $pegawaiKey }}" />
                                        <button type="submit" class="px-3 py-1 ml-2 bg-green-600 hover:bg-green-500 text-white rounded-md text-sm font-medium">Buat User</button>
                                    </form>
                                @else
                                    @php
                                        $hasUser = false;
                                        $linkedUserId = null;
                                        if (isset($usersByPegawai) && is_object($usersByPegawai)) {
                                            if ($usersByPegawai->has($pegawai->id)) {
                                                $hasUser = true;
                                                $linkedUserId = $usersByPegawai->get($pegawai->id)->id;
                                            }
                                        }
                                    @endphp

                                    @if($hasUser)
                                        <a href="{{ route('admin.users.edit', $linkedUserId) }}" class="inline-flex items-center px-3 py-1 mr-2 bg-indigo-500 hover:bg-indigo-400 text-white rounded-md text-sm font-medium">Kelola User</a>
                                    @else
                                        <form action="{{ route('admin.pegawai.create_user') }}" method="POST" class="inline create-user-form">
                                            @csrf
                                            <input type="hidden" name="ref" value="local-{{ $pegawai->id }}" />
                                            <button type="submit" class="inline-flex items-center px-3 py-1 mr-2 bg-emerald-500 hover:bg-emerald-400 text-white rounded-md text-sm font-medium">Buat User</button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.pegawai.edit', $pegawaiKey) }}" class="inline-flex items-center px-2 py-1 mr-2 bg-yellow-400 hover:bg-yellow-300 text-black rounded-md text-sm font-medium">Edit</a>
                                    <form action="{{ route('admin.pegawai.destroy', $pegawaiKey) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus pegawai ini?')" class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-500 text-white rounded-md text-sm font-medium">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-white/10 bg-transparent">
                {{ $pegawais->withQueryString()->links() }}
            </div>
        @else
            <div class="p-6 text-center text-blue-100">Tidak ada data pegawai.</div>
        @endif
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.create-user-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const ref = form.querySelector('input[name="ref"]').value || '';
            let msg = 'Buat user untuk pegawai ini?';
            if (ref.startsWith('simgos-')) {
                msg = 'Pegawai akan diimpor dari SIMGOS lalu user dibuat. Lanjutkan?';
            }
            if (!confirm(msg)) {
                e.preventDefault();
                return;
            }
            // optionally disable submit to avoid double posting
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.textContent = 'Memproses...';
            }
        });
    });
});
</script>
@endpush
