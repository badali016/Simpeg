@extends('layouts.app')

@section('content')
    @include('components.neon-styles')

    <div class="mb-4">
        <h2 class="text-2xl font-semibold text-white">Tambah User</h2>
    </div>

    <div class="neon-card p-4">
        @if($errors->any())
            <div class="mb-4 text-red-400">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            @include('users._form')

            <div class="mt-4">
                <button class="px-4 py-2 bg-emerald-500 text-white rounded-md">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="ml-2 text-blue-100">Batal</a>
            </div>
        </form>
    </div>

@endsection
