@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<div class="mb-4 md:mb-6">
    <h2 class="text-xl md:text-2xl text-slate-900 font-bold">Pengajuan Cuti / Izin (Admin)</h2>
    <p class="text-xs md:text-sm text-slate-600">Daftar pengajuan terbaru</p>
</div>

<style>
    /* Ensure this card sits above any overlay and receives pointer events */
    .admin-leaves-card { position: relative; z-index: 9999; pointer-events: auto; }
    .admin-leaves-card button, .admin-leaves-card a { pointer-events: auto; }
</style>

<div class="admin-leaves-card card p-4 md:p-6 bg-white border border-slate-200 rounded-lg shadow-lg">
    <div class="overflow-x-auto -mx-4 md:mx-0">
        <table class="min-w-full divide-y divide-slate-300 text-sm text-slate-700">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-3 md:px-4 py-2 md:py-3 text-left text-slate-900 font-semibold text-xs whitespace-nowrap">#</th>
                    <th class="px-3 md:px-4 py-2 md:py-3 text-left text-slate-900 font-semibold text-xs whitespace-nowrap">Pegawai</th>
                    <th class="px-3 md:px-4 py-2 md:py-3 text-left text-slate-900 font-semibold text-xs whitespace-nowrap hidden lg:table-cell">Jabatan</th>
                    <th class="px-3 md:px-4 py-2 md:py-3 text-left text-slate-900 font-semibold text-xs whitespace-nowrap">Tipe</th>
                    <th class="px-3 md:px-4 py-2 md:py-3 text-left text-slate-900 font-semibold text-xs whitespace-nowrap hidden md:table-cell">Periode</th>
                    <th class="px-3 md:px-4 py-2 md:py-3 text-left text-slate-900 font-semibold text-xs whitespace-nowrap">Status</th>
                    <th class="px-3 md:px-4 py-2 md:py-3 text-left text-slate-900 font-semibold text-xs whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-transparent">
                @foreach($leaves as $leave)
                    <tr data-href="{{ route('admin.leaves.show', $leave->id) }}" class="group hover:bg-slate-50 cursor-pointer">
                        <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-700 whitespace-nowrap">{{ ($leaves->firstItem() ?? 0) + $loop->index }}</td>
                        <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-900 font-medium whitespace-nowrap">{{ optional($leave->pegawai)->nama ?? '—' }}</td>
                        <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-600 whitespace-nowrap hidden lg:table-cell">{{ optional($leave->pegawai->jabatan)->nama ?? '—' }}</td>
                        <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-700 whitespace-nowrap">{{ $leave->type }}</td>
                        <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-700 whitespace-nowrap hidden md:table-cell">{{ $leave->starts_at }} &rarr; {{ $leave->ends_at }}</td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">@php $s = $leave->status; @endphp
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $s === 'approved' ? 'bg-emerald-600' : ($s === 'rejected' ? 'bg-red-600' : 'bg-yellow-500') }} text-white">{{ $s }}</span>
                        </td>
                        <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                            <button type="button" class="inline-block px-2 md:px-3 py-1.5 min-h-[36px] bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs" onclick="window.location='{{ route('admin.leaves.show', $leave->id) }}'">Lihat</button>
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
