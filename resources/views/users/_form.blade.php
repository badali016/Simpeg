<div class="space-y-4">
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

    <div>
        <label class="block text-sm text-blue-100">Nama</label>
        <input type="text" name="name" value="{{ old('name', $prefillName) }}" class="w-full mt-1 rounded-md bg-slate-800 text-white border border-gray-700 px-3 py-2" required />
    </div>

    <div>
        <label class="block text-sm text-blue-100">Email</label>
        <input type="email" name="email" value="{{ old('email', $prefillEmail) }}" class="w-full mt-1 rounded-md bg-slate-800 text-white border border-gray-700 px-3 py-2" required />
    </div>

    <div>
        <label class="block text-sm text-blue-100">Pegawai (opsional)</label>
        <div class="mb-2">
            <input id="simgos_search" type="search" placeholder="Cari nama atau NIP dari SIMGOS..." class="w-full mt-1 rounded-md bg-slate-800 text-white border border-gray-700 px-3 py-2" />
            <ul id="simgos_suggestions" class="bg-slate-800 border border-gray-700 mt-1 rounded-md max-h-48 overflow-auto hidden"></ul>
        </div>
        <select name="pegawai_ref" class="w-full mt-1 rounded-md bg-slate-800 text-white border border-gray-700 px-3 py-2">
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
        <p class="text-xs text-blue-200 mt-1">Pilih pegawai lokal atau pilih dari SIMGOS untuk mengimpor otomatis.</p>
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
        li.className = 'px-3 py-2 text-sm text-white hover:bg-slate-700 cursor-pointer';
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

    <div>
        <label class="block text-sm text-blue-100">Peran</label>
        <select name="is_admin" class="w-full mt-1 rounded-md bg-slate-800 text-white border border-gray-700 px-3 py-2">
            <option value="0" @if($isAdminSelected === 'user') selected @endif>User</option>
            <option value="1" @if($isAdminSelected === 'admin' || $isAdminSelected === '1') selected @endif>Admin</option>
        </select>
    </div>

    <div>
        <label class="block text-sm text-blue-100">Kata Sandi @if(!$isEdit)<span class="text-xs text-blue-200">(wajib)</span>@else <span class="text-xs text-blue-200">(kosongkan jika tidak ingin mengubah)</span>@endif</label>
        <input type="password" name="password" class="w-full mt-1 rounded-md bg-slate-800 text-white border border-gray-700 px-3 py-2" @if(!$isEdit) required @endif />
    </div>

    <div>
        <label class="block text-sm text-blue-100">Konfirmasi Kata Sandi</label>
        <input type="password" name="password_confirmation" class="w-full mt-1 rounded-md bg-slate-800 text-white border border-gray-700 px-3 py-2" @if(!$isEdit) required @endif />
    </div>
</div>
