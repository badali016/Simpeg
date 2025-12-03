@extends('layouts.app')

@section('content')
    @include('components.neon-styles')

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-2xl font-semibold text-white">Manajemen Users</h2>
            <p class="text-sm text-blue-200/80">Kelola akun dan hak akses pengguna</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white rounded-lg shadow-lg">Tambah User</a>
    </div>

    <div class="card overflow-hidden">
        @if(session('success'))
            <div class="mb-4 text-green-300">{{ session('success') }}</div>
        @endif

        @if($users->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-slate-900/50 text-left text-sm text-blue-100/90">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Pegawai</th>
                            <th class="px-4 py-2">Peran</th>
                            <th class="px-4 py-2 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 bg-transparent">
                        @foreach($users as $user)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-4 py-3 text-slate-400">{{ $user->id }}</td>
                            <td class="px-4 py-3 text-white">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ optional($user->pegawai)->nama ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if($user->is_admin)
                                    <span class="px-2 py-1 bg-indigo-600 text-white rounded text-sm">Admin</span>
                                @else
                                    <span class="px-2 py-1 bg-slate-700 text-blue-100 rounded text-sm">User</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-3 py-1 mr-2 bg-yellow-400 text-black rounded-md text-sm">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus user ini?')" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-white/10 bg-transparent">
                {{ $users->withQueryString()->links() }}
            </div>
        @else
            <div class="p-6 text-center text-blue-100">Belum ada user.</div>
        @endif
    </div>

@endsection
