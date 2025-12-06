@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<h2 class="text-xl md:text-2xl text-white mb-2">Ajukan Cuti / Izin / Sakit / Dinas Luar</h2>
<div class="card p-4 md:p-6">
    <form method="POST" action="{{ route('pegawai.leave.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Tipe</label>
            <select name="type" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2 min-h-[48px]">
                <option value="cuti">Cuti</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="dinas_luar">Dinas Luar</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Mulai</label>
            <input type="datetime-local" name="starts_at" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2 min-h-[48px]" required />
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Selesai</label>
            <input type="datetime-local" name="ends_at" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2 min-h-[48px]" required />
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Alasan</label>
            <textarea name="reason" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2 min-h-[100px]"></textarea>
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Bukti (opsional)</label>
            <input type="file" name="proof" class="w-full mt-1 text-white py-2" />
        </div>
        <button class="w-full sm:w-auto px-6 py-3 min-h-[52px] bg-emerald-500 hover:bg-emerald-600 text-white rounded font-semibold">Kirim Pengajuan</button>
    </form>
</div>

@endsection
