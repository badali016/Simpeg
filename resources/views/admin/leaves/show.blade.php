@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<div class="mb-4">
    <h2 class="text-2xl text-white">Detail Pengajuan Cuti / Izin</h2>
    <p class="text-sm text-blue-200">Detail dan aksi untuk pengajuan</p>
</div>

<style>
    .admin-leave-detail { position: relative; z-index: 9999; pointer-events: auto; }
    .admin-leave-detail button, .admin-leave-detail a { pointer-events: auto; }
</style>

<div class="admin-leave-detail card p-6 bg-slate-800/50 border border-slate-700 rounded-lg shadow-lg">
    <dl class="grid grid-cols-2 gap-4 text-blue-200">
        <div>
            <dt class="font-bold">Pegawai</dt>
            <dd>{{ optional($leave->pegawai)->nama ?? '—' }}</dd>
        </div>
        <div>
            <dt class="font-bold">Tipe</dt>
            <dd>{{ $leave->type }}</dd>
        </div>
        <div>
            <dt class="font-bold">Periode</dt>
            <dd>{{ $leave->starts_at }} &rarr; {{ $leave->ends_at }}</dd>
        </div>
        <div>
            <dt class="font-bold">Status</dt>
            <dd>{{ $leave->status }}</dd>
        </div>
        <div class="col-span-2">
            <dt class="font-bold">Alasan</dt>
            <dd>{{ $leave->reason }}</dd>
        </div>
        @if($leave->proof_path)
            <div class="col-span-2">
                <dt class="font-bold">Bukti</dt>
                <dd><a href="{{ asset('storage/' . $leave->proof_path) }}" target="_blank" class="text-emerald-300">Lihat berkas</a></dd>
            </div>
        @endif
    </dl>

    <div class="mt-4 flex gap-3">
        <form action="{{ route('admin.leaves.approve', $leave->id) }}" method="post">
            @csrf
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded">Setujui</button>
        </form>

        <form action="{{ route('admin.leaves.reject', $leave->id) }}" method="post">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Tolak</button>
        </form>

        <a href="{{ route('admin.leaves.index') }}" class="px-4 py-2 bg-slate-700 text-white rounded">Kembali</a>
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
