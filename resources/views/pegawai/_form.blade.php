<!-- Data Utama -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Data Utama</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Pegawai <span class="text-red-500">*</span></label>
            <input id="nama" name="nama" type="text" value="{{ old('nama', isset($pegawai) ? $pegawai->nama : '') }}" required
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="Masukkan nama lengkap">
        </div>

        <div>
            <label for="nip" class="block text-sm font-semibold text-slate-700 mb-2">NIP <span class="text-red-500">*</span></label>
            <input id="nip" name="nip" type="text" value="{{ old('nip', isset($pegawai) ? $pegawai->nip : '') }}" required
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="Nomor Induk Pegawai">
        </div>

        <div class="md:col-span-2">
            <label for="profesi" class="block text-sm font-semibold text-slate-700 mb-2">Profesi (dari SIMGOS)</label>
            <select id="profesi" name="profesi" 
                    class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                <option value="">-- Pilih Profesi --</option>
                @foreach($profesiList as $key => $label)
                    <option value="{{ $key }}" {{ (string) old('profesi', isset($pegawai) ? ($pegawai->profesi ?? '') : '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- Kontak -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Informasi Kontak</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', isset($pegawai) ? $pegawai->email : '') }}"
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="nama@email.com">
        </div>

        <div>
            <label for="no_telepon" class="block text-sm font-semibold text-slate-700 mb-2">No. Telepon</label>
            <input id="no_telepon" name="no_telepon" type="text" value="{{ old('no_telepon', isset($pegawai) ? ($pegawai->no_telepon ?? '') : '') }}"
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="08xxxxxxxxxx">
        </div>
    </div>
</div>

<!-- Actions -->
<div class="flex items-center justify-between pt-6 border-t border-slate-200">
    <a href="{{ route('admin.pegawai.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border-2 border-slate-300 rounded-lg hover:bg-slate-50 transition">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Batal
    </a>
    <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition transform hover:scale-105">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Simpan Data
    </button>
</div>
