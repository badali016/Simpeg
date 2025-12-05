@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<div class="mb-6">
    <h2 class="text-2xl text-white">Pengajuan Cuti / Izin (Admin)</h2>
    <p class="text-sm text-blue-200">Daftar pengajuan terbaru</p>
</div>

<style>
    /* Ensure this card sits above any overlay and receives pointer events */
    .admin-leaves-card { position: relative; z-index: 9999; pointer-events: auto; }
    .admin-leaves-card button, .admin-leaves-card a { pointer-events: auto; }
</style>

<div class="admin-leaves-card card p-6 bg-slate-800/50 border border-slate-700 rounded-lg shadow-lg">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-700 text-sm text-blue-200">
            <thead class="bg-slate-900/40">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Pegawai</th>
                    <th class="px-4 py-3 text-left">Tipe</th>
                    <th class="px-4 py-3 text-left">Periode</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-transparent">
                @foreach($leaves as $leave)
                    <tr data-href="{{ route('admin.leaves.show', $leave->id) }}" class="group hover:bg-slate-800 cursor-pointer">
                        <td class="px-4 py-3">{{ ($leaves->firstItem() ?? 0) + $loop->index }}</td>
                        <td class="px-4 py-3">{{ optional($leave->pegawai)->nama ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $leave->type }}</td>
                        <td class="px-4 py-3">{{ $leave->starts_at }} &rarr; {{ $leave->ends_at }}</td>
                        <td class="px-4 py-3">@php $s = $leave->status; @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $s === 'approved' ? 'bg-emerald-600' : ($s === 'rejected' ? 'bg-red-600' : 'bg-yellow-500') }} text-black">{{ $s }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <button type="button" class="inline-block px-3 py-1 bg-indigo-600 text-white rounded text-sm" onclick="window.location='{{ route('admin.leaves.show', $leave->id) }}'">Lihat</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $leaves->links() }}
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
        } catch (e) { /* ignore */ }

        // Make table rows clickable (except when clicking the button)
        document.querySelectorAll('tr[data-href]').forEach(function(row){
            row.addEventListener('click', function(e){
                if (e.target.closest('button') || e.target.closest('a') || e.target.closest('form')) return;
                var href = row.getAttribute('data-href');
                if (href) window.location = href;
            });
        });
    });
</script>
@endpush

@endsection
