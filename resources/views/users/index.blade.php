@extends('layouts.app')

@section('content')
    @include('components.neon-styles')

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4">
        <div class="flex-1 min-w-0">
            <h2 class="text-xl md:text-2xl font-semibold text-slate-900">Manajemen Users</h2>
            <p class="text-xs md:text-sm text-slate-500">Kelola akun dan hak akses pengguna</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-3 md:px-4 py-2.5 min-h-[44px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md text-sm whitespace-nowrap">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="hidden sm:inline">Tambah User</span>
            <span class="sm:hidden">Tambah</span>
        </a>
    </div>

    <div class="card overflow-hidden">
        @if(session('success'))
            <div class="mb-4 text-green-300">{{ session('success') }}</div>
        @endif

        @if($users->count())
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-100 text-left text-xs text-slate-600">
                        <tr>
                            <th class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">#</th>
                            <th class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">Nama</th>
                            <th class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">Email</th>
                            <th class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">Pegawai</th>
                            <th class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">Peran</th>
                            <th class="px-3 md:px-4 py-2 md:py-3 text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 bg-transparent">
                        @foreach($users as $user)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-500 whitespace-nowrap">{{ $user->id }}</td>
                            <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-800 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-700 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm text-slate-700 whitespace-nowrap">{{ optional($user->pegawai)->nama ?? '-' }}</td>
                            <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                                @if($user->is_admin)
                                    <span class="px-2 py-1 bg-indigo-600 text-white rounded text-xs">Admin</span>
                                @else
                                    <span class="px-2 py-1 bg-slate-700 text-blue-100 rounded text-xs">User</span>
                                @endif
                            </td>
                            <td class="px-3 md:px-4 py-2 md:py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-2 md:px-3 py-1.5 min-h-[36px] mr-1 md:mr-2 bg-yellow-400 text-black rounded-md text-xs">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus user ini?')" class="inline-flex items-center px-2 md:px-3 py-1.5 min-h-[36px] bg-red-600 text-white rounded-md text-xs">Hapus</button>
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
