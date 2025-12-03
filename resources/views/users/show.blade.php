@extends('layouts.app')

@section('content')
    @include('components.neon-styles')

    <div class="mb-4">
        <h2 class="text-2xl font-semibold text-white">Detail User</h2>
    </div>

    <div class="neon-card p-4">
        <div class="space-y-2">
            <div><strong class="text-blue-100">Nama:</strong> <span class="text-white">{{ $user->name }}</span></div>
            <div><strong class="text-blue-100">Email:</strong> <span class="text-blue-100">{{ $user->email }}</span></div>
            <div><strong class="text-blue-100">Pegawai:</strong> <span class="text-blue-100">{{ optional($user->pegawai)->nama ?? '-' }}</span></div>
            <div><strong class="text-blue-100">Peran:</strong> <span class="text-blue-100">{{ $user->is_admin ? 'Admin' : 'User' }}</span></div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1 bg-yellow-400 text-black rounded-md">Edit</a>
            <a href="{{ route('admin.users.index') }}" class="ml-2 text-blue-100">Kembali</a>
        </div>
    </div>

@endsection
