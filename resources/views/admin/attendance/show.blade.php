@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<h2 class="text-2xl text-white mb-4">Detail Koreksi #{{ $a->id }}</h2>

<div class="card p-4">
    <p><strong>Pegawai:</strong> {{ optional($a->pegawai)->nama ?? '-' }}</p>
    <p><strong>Waktu yang diminta:</strong> {{ $a->recorded_at }}</p>
    <p><strong>Catatan:</strong> {{ $a->notes }}</p>

    <form method="POST" action="{{ route('admin.attendance.resolve', $a->id) }}">
        @csrf
        <button class="px-3 py-1 bg-emerald-500 text-white rounded">Tandai Selesai</button>
    </form>
</div>

@endsection
