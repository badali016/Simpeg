@csrf

<!-- Informasi Jabatan -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Informasi Jabatan</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label for="nama_jabatan" class="block text-sm font-semibold text-slate-700 mb-2">Nama Jabatan <span class="text-red-500">*</span></label>
            <input id="nama_jabatan" name="nama_jabatan" type="text" value="{{ old('nama_jabatan', isset($jabatan) ? $jabatan->nama_jabatan : '') }}" required
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="Masukkan nama jabatan">
        </div>

        <div>
            <label for="kode_jabatan" class="block text-sm font-semibold text-slate-700 mb-2">Kode Jabatan <span class="text-red-500">*</span></label>
            <input id="kode_jabatan" name="kode_jabatan" type="text" value="{{ old('kode_jabatan', isset($jabatan) ? $jabatan->kode_jabatan : '') }}" required
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="Contoh: JB-001">
        </div>

        <div>
            <label for="eselon" class="block text-sm font-semibold text-slate-700 mb-2">Eselon</label>
            <input id="eselon" name="eselon" type="text" value="{{ old('eselon', isset($jabatan) ? $jabatan->eselon : '') }}"
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="Contoh: II, III, IV">
        </div>

        <div>
            <label for="unit_kerja" class="block text-sm font-semibold text-slate-700 mb-2">Unit Kerja</label>
            <input id="unit_kerja" name="unit_kerja" type="text" value="{{ old('unit_kerja', isset($jabatan) ? $jabatan->unit_kerja : '') }}"
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="Nama unit kerja">
        </div>

        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
            <select id="status" name="status" 
                    class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                <option value="Aktif" {{ old('status', isset($jabatan) ? $jabatan->status : '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status', isset($jabatan) ? $jabatan->status : '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
    </div>
</div>

<!-- Actions -->
<div class="flex items-center justify-between pt-6 border-t border-slate-200">
    <a href="{{ route('admin.jabatan.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border-2 border-slate-300 rounded-lg hover:bg-slate-50 transition">
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
