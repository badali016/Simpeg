@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<h2 class="text-xl md:text-2xl text-white mb-2">Ubah Kontak</h2>
<div class="card p-4 md:p-6">
    <form method="POST" action="{{ route('pegawai.profile.update') }}">
        @csrf
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Email</label>
            <input type="email" name="email" value="{{ old('email', $pegawai->email) }}" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2 min-h-[48px]" />
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Alamat</label>
            <textarea name="alamat" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2 min-h-[100px]">{{ old('alamat', $pegawai->alamat) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $pegawai->phone ?? '') }}" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2 min-h-[48px]" />
        </div>
        <button class="w-full sm:w-auto px-6 py-3 min-h-[52px] bg-emerald-500 hover:bg-emerald-600 text-white rounded font-semibold">Simpan</button>
    </form>
</div>

@endsection
