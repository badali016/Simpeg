@php
    $isEdit = isset($user);
    // support prefilling from query string when opening create via link
    $prefillName = $isEdit ? ($user->name ?? '') : request('name', '');
    $prefillEmail = $isEdit ? ($user->email ?? '') : request('email', '');
    $prefillPegawaiRef = '';
    if ($isEdit) {
        $prefillPegawaiRef = $user->pegawai_id ? 'local-' . $user->pegawai_id : '';
    } else {
        if (request()->has('pegawai_id') && request('pegawai_id')) {
            $prefillPegawaiRef = 'local-' . request('pegawai_id');
        } elseif (request()->has('simgos_nip') && request('simgos_nip')) {
            $prefillPegawaiRef = 'simgos-' . request('simgos_nip');
        }
    }

    $selectedPegawaiRef = old('pegawai_ref', $prefillPegawaiRef);
    $isAdminSelected = old('is_admin', $isEdit ? ($user->is_admin ? 'admin' : 'user') : 'user');
@endphp

<!-- Informasi Akun -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Informasi Akun</h3>
    <div class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama <span class="text-red-500">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name', $prefillName) }}" required
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="Nama lengkap pengguna" />
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
            <input id="email" type="email" name="email" value="{{ old('email', $prefillEmail) }}" required
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="email@example.com" />
        </div>
    </div>
</div>

<!-- Relasi Pegawai -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Relasi Pegawai</h3>
    <div>
        <label for="pegawai_ref" class="block text-sm font-semibold text-slate-700 mb-2">Pegawai (opsional)</label>
        <div class="mb-3">
            <input id="simgos_search" type="search" placeholder="🔍 Cari nama atau NIP dari SIMGOS..." 
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-500 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
            <ul id="simgos_suggestions" class="bg-white border-2 border-slate-300 mt-2 rounded-lg max-h-48 overflow-auto hidden shadow-lg"></ul>
        </div>
        <select id="pegawai_ref" name="pegawai_ref" 
                class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
            <option value="">- Tidak dipilih -</option>
            <optgroup label="Pegawai Lokal">
                @foreach(($pegawais ?? []) as $p)
                    @php $val = 'local-' . $p->id; @endphp
                    <option value="{{ $val }}" @if(old('pegawai_ref', $selectedPegawaiRef) == $val) selected @endif>{{ $p->nama }} ({{ $p->nip ?? '-' }})</option>
                @endforeach
            </optgroup>
            @if(!empty($pegawaisSimgos ?? []))
            <optgroup label="Pegawai SIMGOS (eksternal)">
                @foreach($pegawaisSimgos as $sp)
                    @php $sVal = 'simgos-' . ($sp->NIP ?? $sp->nip ?? ''); @endphp
                    <option value="{{ $sVal }}" @if(old('pegawai_ref', $selectedPegawaiRef) == $sVal) selected @endif>{{ $sp->NAMA ?? $sp->nama }} ({{ $sp->NIP ?? '-' }})</option>
                @endforeach
            </optgroup>
            @endif
        </select>
        <p class="text-xs text-slate-600 mt-2">💡 Pilih pegawai lokal atau cari dari SIMGOS untuk mengimpor otomatis</p>
    </div>
</div>

<script>
(() => {
    const input = document.getElementById('simgos_search');
    const sug = document.getElementById('simgos_suggestions');
    const select = document.querySelector('select[name="pegawai_ref"]');
    let timer = null;

    function clearSuggestions() {
        sug.innerHTML = '';
        sug.classList.add('hidden');
    }

    function addSuggestion(item) {
        const li = document.createElement('li');
        li.className = 'px-4 py-3 text-sm text-slate-900 hover:bg-blue-50 cursor-pointer border-b border-slate-200 last:border-b-0';
        li.textContent = (item.NAMA || item.nama) + ' (' + (item.NIP || item.nip || '') + ')';
        li.dataset.nip = item.NIP || item.nip;
        li.addEventListener('click', () => {
            // create option if not exists
            const val = 'simgos-' + li.dataset.nip;
            let opt = Array.from(select.options).find(o => o.value === val);
            if (!opt) {
                opt = document.createElement('option');
                opt.value = val;
                opt.text = li.textContent;
                select.appendChild(opt);
            }
            select.value = val;
            clearSuggestions();
            input.value = '';
        });
        sug.appendChild(li);
    }

    input.addEventListener('input', (e) => {
        const q = e.target.value.trim();
        clearTimeout(timer);
        if (q.length < 2) { clearSuggestions(); return; }
        timer = setTimeout(() => {
            fetch(`{{ route('admin.simgos.search') }}?q=` + encodeURIComponent(q))
                .then(r => r.json())
                .then(data => {
                    clearSuggestions();
                    if (!Array.isArray(data) || data.length === 0) return;
                    data.forEach(addSuggestion);
                    sug.classList.remove('hidden');
                }).catch(() => {
                    clearSuggestions();
                });
        }, 300);
    });

    // hide on outside click
    document.addEventListener('click', (ev) => {
        if (!sug.contains(ev.target) && ev.target !== input) {
            clearSuggestions();
        }
    });

    // if user submits form and selected pegawai_ref is simgos, confirm
    const form = input.closest('form');
    if (form) {
        form.addEventListener('submit', (ev) => {
            const sel = select.value || '';
            if (sel.startsWith('simgos-')) {
                const ok = confirm('Anda memilih pegawai dari SIMGOS — data akan diimpor ke database lokal saat menyimpan. Lanjutkan?');
                if (!ok) ev.preventDefault();
            }
        });
    }
})();
</script>

<!-- Role & Keamanan -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Peran & Keamanan</h3>
    <div class="space-y-6">
        <div>
            <label for="is_admin" class="block text-sm font-semibold text-slate-700 mb-2">Peran <span class="text-red-500">*</span></label>
            <select id="is_admin" name="is_admin" 
                    class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                <option value="0" @if($isAdminSelected === 'user') selected @endif>👤 User (Pegawai)</option>
                <option value="1" @if($isAdminSelected === 'admin' || $isAdminSelected === '1') selected @endif>👑 Admin (Administrator)</option>
            </select>
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                Kata Sandi 
                @if(!$isEdit)
                    <span class="text-red-500">*</span>
                @else 
                    <span class="text-xs text-slate-500 font-normal">(kosongkan jika tidak ingin mengubah)</span>
                @endif
            </label>
            <input id="password" type="password" name="password" @if(!$isEdit) required @endif
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="••••••••" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi @if(!$isEdit)<span class="text-red-500">*</span>@endif</label>
            <input id="password_confirmation" type="password" name="password_confirmation" @if(!$isEdit) required @endif
                   class="block w-full rounded-lg border-2 border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                   placeholder="••••••••" />
        </div>
    </div>
</div>

<!-- Actions -->
<div class="flex items-center justify-between pt-6 border-t border-slate-200">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border-2 border-slate-300 rounded-lg hover:bg-slate-50 transition">
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
