@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<h2 class="text-2xl text-white mb-4">Koreksi Presensi (Admin)</h2>

<div class="card p-4">
    @if(session('success'))<div class="text-green-300 mb-3">{{ session('success') }}</div>@endif
    @if($corrections->count())
        <table class="min-w-full">
            <thead>
                <tr class="text-left text-sm text-blue-200">
                    <th class="px-2 py-1">#</th>
                    <th class="px-2 py-1">Pegawai</th>
                    <th class="px-2 py-1">Requested Time</th>
                    <th class="px-2 py-1">Notes</th>
                    <th class="px-2 py-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($corrections as $c)
                <tr class="border-t border-white/10">
                    <td class="px-2 py-2">{{ $c->id }}</td>
                    <td class="px-2 py-2">{{ optional($c->pegawai)->nama ?? '-' }}</td>
                    <td class="px-2 py-2">{{ $c->recorded_at }}</td>
                    <td class="px-2 py-2">{{ \Illuminate\Support\Str::limit($c->notes, 80) }}</td>
                    <td class="px-2 py-2">
                        <a href="{{ route('admin.attendance.show', $c->id) }}" class="px-2 py-1 bg-slate-700 text-white rounded">Lihat</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $corrections->links() }}</div>
    @else
        <div>Tidak ada koreksi.</div>
    @endif
</div>

@endsection
