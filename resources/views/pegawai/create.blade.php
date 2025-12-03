@extends('layouts.app')

@section('content')
    @include('components.neon-styles')
    <div class="max-w-2xl mx-auto neon-card">
        <h2 class="text-2xl font-semibold mb-4">Tambah Pegawai</h2>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-700 rounded border border-red-100">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pegawai.store') }}" method="POST">
            @csrf
            @include('pegawai._form')
        </form>
    </div>
@endsection
