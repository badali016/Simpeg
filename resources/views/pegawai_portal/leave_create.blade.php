@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<h2 class="text-2xl text-white mb-2">Ajukan Cuti / Izin / Sakit / Dinas Luar</h2>
<div class="card p-4">
    <form method="POST" action="{{ route('pegawai.leave.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Tipe</label>
            <select name="type" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2">
                <option value="cuti">Cuti</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="dinas_luar">Dinas Luar</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Mulai</label>
            <input type="datetime-local" name="starts_at" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2" required />
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Selesai</label>
            <input type="datetime-local" name="ends_at" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2" required />
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Alasan</label>
            <textarea name="reason" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2"></textarea>
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Bukti (opsional)</label>
            <input type="file" name="proof" class="w-full mt-1 text-white" />
        </div>
        <button class="px-4 py-2 bg-emerald-500 text-white rounded">Kirim Pengajuan</button>
    </form>
</div>

@endsection
