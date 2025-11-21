@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="nama_jabatan" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
        <input id="nama_jabatan" name="nama_jabatan" type="text" value="{{ old('nama_jabatan', isset($jabatan) ? $jabatan->nama_jabatan : '') }}" required
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>

    <div>
        <label for="kode_jabatan" class="block text-sm font-medium text-gray-700">Kode Jabatan</label>
        <input id="kode_jabatan" name="kode_jabatan" type="text" value="{{ old('kode_jabatan', isset($jabatan) ? $jabatan->kode_jabatan : '') }}" required
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>

    <div>
        <label for="eselon" class="block text-sm font-medium text-gray-700">Eselon</label>
        <input id="eselon" name="eselon" type="text" value="{{ old('eselon', isset($jabatan) ? $jabatan->eselon : '') }}"
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>

    <div>
        <label for="unit_kerja" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
        <input id="unit_kerja" name="unit_kerja" type="text" value="{{ old('unit_kerja', isset($jabatan) ? $jabatan->unit_kerja : '') }}"
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <input id="status" name="status" type="text" value="{{ old('status', isset($jabatan) ? $jabatan->status : '') }}"
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#f53003] text-white rounded-md shadow hover:bg-[#d02403]">Simpan</button>
    <a href="{{ route('jabatan.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
</div>
