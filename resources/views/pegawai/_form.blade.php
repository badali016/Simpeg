@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Pegawai</label>
        <input id="nama" name="nama" type="text" value="{{ old('nama', isset($pegawai) ? $pegawai->nama : '') }}" required
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>

    <div>
        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
        <input id="nip" name="nip" type="text" value="{{ old('nip', isset($pegawai) ? $pegawai->nip : '') }}" required
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>

    <div class="md:col-span-2">
        <label for="profesi" class="block text-sm font-medium text-gray-700">Profesi (dari SIMGOS)</label>
        <select id="profesi" name="profesi" class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm">
            <option value="">-- Pilih Profesi --</option>
            @foreach($profesiList as $key => $label)
                <option value="{{ $key }}" {{ (string) old('profesi', isset($pegawai) ? ($pegawai->profesi ?? '') : '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', isset($pegawai) ? $pegawai->email : '') }}"
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>

    <div>
        <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
        <input id="no_telepon" name="no_telepon" type="text" value="{{ old('no_telepon', isset($pegawai) ? ($pegawai->no_telepon ?? '') : '') }}"
               class="mt-1 block w-full rounded-md border border-gray-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#f53003]">
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#f53003] text-white rounded-md shadow hover:bg-[#d02403]">Simpan</button>
    <a href="{{ route('pegawai.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
</div>
