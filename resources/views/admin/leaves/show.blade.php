@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<div class="mb-4">
    <h2 class="text-2xl text-slate-900 font-bold">Detail Pengajuan Cuti / Izin</h2>
    <p class="text-sm text-slate-600">Detail dan aksi untuk pengajuan</p>
</div>

<style>
    .admin-leave-detail { position: relative; z-index: 9999; pointer-events: auto; }
    .admin-leave-detail button, .admin-leave-detail a { pointer-events: auto; }
</style>

<div class="admin-leave-detail card p-6 bg-white border border-slate-200 rounded-lg shadow-lg">
    <dl class="grid grid-cols-2 gap-4 text-slate-700">
        <div>
            <dt class="font-bold text-slate-900">Pegawai</dt>
            <dd>{{ optional($leave->pegawai)->nama ?? '—' }}</dd>
        </div>
        <div>
            <dt class="font-bold text-slate-900">Jabatan</dt>
            <dd>{{ optional($leave->pegawai->jabatan)->nama ?? '—' }}</dd>
        </div>
        <div>
            <dt class="font-bold text-slate-900">Tipe</dt>
            <dd>{{ $leave->type }}</dd>
        </div>
        <div>
            <dt class="font-bold text-slate-900">Periode</dt>
            <dd>{{ $leave->starts_at }} &rarr; {{ $leave->ends_at }}</dd>
        </div>
        <div>
            <dt class="font-bold text-slate-900">Status</dt>
            <dd>{{ $leave->status }}</dd>
        </div>
        <div class="col-span-2">
            <dt class="font-bold text-slate-900">Alasan</dt>
            <dd>{{ $leave->reason }}</dd>
        </div>
        @if($leave->proof_path)
            <div class="col-span-2">
                <dt class="font-bold text-slate-900">Bukti</dt>
                <dd><a href="{{ asset('storage/' . $leave->proof_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">Lihat berkas</a></dd>
            </div>
        @endif
    </dl>

    <div class="mt-4 flex gap-3">
        <form action="{{ route('admin.leaves.approve', $leave->id) }}" method="post">
            @csrf
            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded">Setujui</button>
        </form>

        <form action="{{ route('admin.leaves.reject', $leave->id) }}" method="post">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Tolak</button>
        </form>

        <a href="{{ route('admin.leaves.index') }}" class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded">Kembali</a>
    </div>
</div>

@push('scripts')
<script>
    // Disable the global layout overlay's pointer interception on this page
    document.addEventListener('DOMContentLoaded', function(){
        try {
            document.querySelectorAll('.layout-overlay, .layout-menu-toggle').forEach(function(el){
                el.style.pointerEvents = 'none';
            });
        } catch(e) {}
    });
</script>
@endpush

@endsection
