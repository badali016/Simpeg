@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<div class="mb-4">
    <h2 class="text-2xl text-white">Riwayat Pengajuan Cuti / Izin</h2>
    <p class="text-sm text-blue-200">Semua pengajuan Anda. Gunakan filter untuk menyaring berdasarkan status.</p>
</div>

<div class="card p-4 admin-leaves-card">
    <form method="get" class="mb-4 flex gap-2 items-center">
        <label class="text-sm text-blue-200">Status:</label>
        <select name="status" class="px-3 py-2 bg-slate-900 text-blue-200 rounded">
            <option value="">Semua</option>
            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <button class="px-3 py-2 bg-indigo-600 text-white rounded">Filter</button>
        <a href="{{ route('pegawai.leaves.index') }}" class="ml-2 px-3 py-2 bg-slate-700 text-white rounded">Reset</a>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-blue-200">
            <thead class="bg-slate-900/40">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">Tipe</th>
                    <th class="px-3 py-2 text-left">Periode</th>
                    <th class="px-3 py-2 text-left">Status</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $i => $l)
                <tr class="border-t border-slate-700">
                    <td class="px-3 py-2">{{ ($leaves->firstItem() ?? 0) + $loop->index }}</td>
                    <td class="px-3 py-2">{{ ucfirst($l->type) }}</td>
                    <td class="px-3 py-2">{{ \Illuminate\Support\Carbon::parse($l->starts_at)->format('Y-m-d') }} → {{ \Illuminate\Support\Carbon::parse($l->ends_at)->format('Y-m-d') }}</td>
                    <td class="px-3 py-2">
                        @php $s=$l->status; @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $s==='approved'?'bg-emerald-500 text-white':($s==='rejected'?'bg-red-500 text-white':'bg-yellow-300 text-black') }}">{{ $s }}</span>
                    </td>
                    <td class="px-3 py-2">
                        <button type="button" class="px-3 py-1 bg-indigo-600 text-white rounded open-leave-detail" data-leave='@json($l)'>Detail</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $leaves->links() }}</div>
</div>

<!-- Modal -->
<div id="leave-modal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
    <div class="bg-slate-900 rounded-lg p-6 w-3/4 max-w-2xl text-blue-200">
        <h3 id="modal-title" class="text-lg font-semibold mb-2">Detail Pengajuan</h3>
        <div id="modal-body" class="space-y-2 mb-4"></div>
        <div class="flex gap-2 justify-end">
            <button id="modal-close" class="px-3 py-2 bg-slate-700 text-white rounded">Tutup</button>
            @auth
                @if(auth()->user()->is_admin)
                    <form id="modal-approve-form" method="post" action="" style="display:inline">@csrf<button class="px-3 py-2 bg-emerald-600 text-white rounded">Setujui</button></form>
                    <form id="modal-reject-form" method="post" action="" style="display:inline">@csrf<button class="px-3 py-2 bg-red-600 text-white rounded">Tolak</button></form>
                @endif
            @endauth
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.open-leave-detail').forEach(function(btn){
            btn.addEventListener('click', function(){
                var data = JSON.parse(btn.getAttribute('data-leave'));
                document.getElementById('modal-title').textContent = 'Pengajuan #' + data.id;
                var body = '';
                body += '<p><strong>Pegawai:</strong> ' + (data.pegawai?data.pegawai.nama:'-') + '</p>';
                body += '<p><strong>Tipe:</strong> ' + data.type + '</p>';
                body += '<p><strong>Periode:</strong> ' + data.starts_at + ' → ' + data.ends_at + '</p>';
                body += '<p><strong>Alasan:</strong> ' + (data.reason || '-') + '</p>';
                if (data.proof_path) body += '<p><strong>Bukti:</strong> <a href="' + '/storage/' + data.proof_path + '" target="_blank">Lihat</a></p>';
                body += '<p><strong>Status:</strong> ' + data.status + '</p>';
                document.getElementById('modal-body').innerHTML = body;
                // wire admin forms
                var approveForm = document.getElementById('modal-approve-form');
                var rejectForm = document.getElementById('modal-reject-form');
                if (approveForm) approveForm.action = '/admin/leaves/' + data.id + '/approve';
                if (rejectForm) rejectForm.action = '/admin/leaves/' + data.id + '/reject';
                document.getElementById('leave-modal').classList.remove('hidden');
                document.getElementById('leave-modal').classList.add('flex');
            });
        });

        document.getElementById('modal-close').addEventListener('click', function(){
            document.getElementById('leave-modal').classList.remove('flex');
            document.getElementById('leave-modal').classList.add('hidden');
        });
    });
</script>
@endpush

@endsection
