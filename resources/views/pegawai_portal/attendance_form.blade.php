@extends('layouts.app')

@section('content')
@include('components.neon-styles')

<h2 class="text-2xl text-white mb-2">Presensi (Clock-in/out)</h2>
<div class="card p-4">
    <form method="POST" action="{{ route('pegawai.attendance.store') }}" id="attendance-form">
        @csrf
        <input type="hidden" name="type" value="in" />
        <input type="hidden" name="latitude" id="latitude" />
        <input type="hidden" name="longitude" id="longitude" />
        <input type="hidden" name="geofence_ok" id="geofence_ok" value="0" />

        <div class="mb-3">
            <label class="block text-sm text-blue-100">Lokasi saat ini</label>
            <div class="flex gap-2 items-center">
                <div id="location-status" class="text-sm text-slate-400">Belum mengambil lokasi</div>
                <button type="button" id="detect-location" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Ambil Lokasi</button>
                <button type="button" id="retry-location" class="px-3 py-1 bg-slate-700 text-white rounded text-sm hidden">Coba Lagi</button>
            </div>
            <div id="location-info" class="mt-2 text-xs text-slate-400"></div>

            <div class="mt-2 text-sm">
                <a href="#" id="show-manual" class="text-indigo-300">Masukkan lokasi secara manual</a>
            </div>

            <div id="manual-entry" class="mt-2 hidden">
                <label class="block text-xs text-slate-400">Latitude</label>
                <input type="text" id="manual-lat" name="latitude_manual" class="w-48 mt-1 rounded-md bg-slate-800 text-white px-3 py-2" />
                <label class="block text-xs text-slate-400 mt-2">Longitude</label>
                <input type="text" id="manual-lng" name="longitude_manual" class="w-48 mt-1 rounded-md bg-slate-800 text-white px-3 py-2" />
                <div class="mt-2">
                    <button type="button" id="apply-manual" class="px-3 py-1 bg-emerald-600 text-white rounded text-sm">Gunakan Lokasi Manual</button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="block text-sm text-blue-100">Catatan</label>
            <textarea name="notes" class="w-full mt-1 rounded-md bg-slate-800 text-white px-3 py-2"></textarea>
        </div>
        <button class="px-4 py-2 bg-emerald-500 text-white rounded" id="attendance-submit">Clock In / Submit</button>
    </form>
</div>
 
@push('scripts')
<script>
    (function(){
        const detectBtn = document.getElementById('detect-location');
        const statusEl = document.getElementById('location-status');
        const infoEl = document.getElementById('location-info');
        const latEl = document.getElementById('latitude');
        const lngEl = document.getElementById('longitude');
        const geofenceEl = document.getElementById('geofence_ok');
        const submitBtn = document.getElementById('attendance-submit');

        // Read geofence config from environment (rendered server-side)
        const radiusMeters = parseFloat('{{ env("GEOFENCE_RADIUS_METERS", 100) }}');
        const officeLat = parseFloat('{{ env("GEOFENCE_LAT") ?? "0" }}');
        const officeLng = parseFloat('{{ env("GEOFENCE_LNG") ?? "0" }}');

        function haversine(lat1, lon1, lat2, lon2) {
            function toRad(v){return v * Math.PI/180;}
            var R = 6371000; // meters
            var dLat = toRad(lat2-lat1);
            var dLon = toRad(lon2-lon1);
            var a = Math.sin(dLat/2)*Math.sin(dLat/2) + Math.cos(toRad(lat1))*Math.cos(toRad(lat2))*Math.sin(dLon/2)*Math.sin(dLon/2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        function setSearching(on){
            detectBtn.disabled = on;
            retryBtn.classList.toggle('hidden', on);
            if (on) {
                detectBtn.textContent = 'Mencari…';
            } else {
                detectBtn.textContent = 'Ambil Lokasi';
            }
        }

        detectBtn.addEventListener('click', doLocate);
        const retryBtn = document.getElementById('retry-location');
        retryBtn.addEventListener('click', doLocate);

        function doLocate(){
            if (!navigator.geolocation) {
                statusEl.textContent = 'Geolocation tidak tersedia pada browser ini.';
                return;
            }
            statusEl.textContent = 'Mencari lokasi…';
            setSearching(true);
            navigator.geolocation.getCurrentPosition(function(pos){
                setSearching(false);
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const acc = pos.coords.accuracy || 0;
                latEl.value = lat;
                lngEl.value = lng;
                statusEl.textContent = 'Lokasi berhasil diambil (akurasi ~' + Math.round(acc) + ' m)';
                const dist = haversine(lat, lng, officeLat, officeLng);
                infoEl.innerHTML = 'Lat: ' + lat.toFixed(6) + ' Lng: ' + lng.toFixed(6) + ' — Jarak ke kantor: ' + Math.round(dist) + ' m';
                if (!officeLat || !officeLng) {
                    infoEl.innerHTML += ' (geofence belum dikonfigurasi)';
                    geofenceEl.value = 0;
                } else if (dist <= radiusMeters) {
                    infoEl.innerHTML += ' — Dalam area kerja';
                    geofenceEl.value = 1;
                } else {
                    infoEl.innerHTML += ' — Diluar area kerja';
                    geofenceEl.value = 0;
                }
            }, function(err){
                setSearching(false);
                var msg = 'Gagal mengambil lokasi.';
                if (err && err.code) {
                    if (err.code === err.PERMISSION_DENIED) msg = 'Izin lokasi ditolak. Pastikan browser mengizinkan akses lokasi.';
                    else if (err.code === err.POSITION_UNAVAILABLE) msg = 'Posisi tidak tersedia.';
                    else if (err.code === err.TIMEOUT) msg = 'Timeout expired';
                    else msg = err.message || msg;
                }
                statusEl.textContent = msg;
                retryBtn.classList.remove('hidden');
                // reveal manual entry option
                document.getElementById('manual-entry').classList.remove('hidden');
            }, { enableHighAccuracy: true, timeout: 30000, maximumAge: 0 });
        }

        // manual fallback
        document.getElementById('show-manual').addEventListener('click', function(e){ e.preventDefault(); document.getElementById('manual-entry').classList.toggle('hidden'); });
        document.getElementById('apply-manual').addEventListener('click', function(){
            var ml = document.getElementById('manual-lat').value.trim();
            var mg = document.getElementById('manual-lng').value.trim();
            if (!ml || !mg) { alert('Masukkan latitude dan longitude.'); return; }
            var lat = parseFloat(ml); var lng = parseFloat(mg);
            if (isNaN(lat) || isNaN(lng)) { alert('Koordinat tidak valid.'); return; }
            latEl.value = lat; lngEl.value = lng;
            var dist = haversine(lat, lng, officeLat, officeLng);
            infoEl.innerHTML = 'Lat: ' + lat.toFixed(6) + ' Lng: ' + lng.toFixed(6) + ' — Jarak ke kantor: ' + Math.round(dist) + ' m (manual)';
            geofenceEl.value = (officeLat && officeLng && dist <= radiusMeters) ? 1 : 0;
            statusEl.textContent = 'Lokasi manual diterapkan';
        });

        // Optionally, prevent submit if geofence enforced and not inside
        document.getElementById('attendance-form').addEventListener('submit', function(e){
            const enforce = '{{ env("GEOFENCE_ENFORCE", false) }}' === 'true';
            if (enforce && geofenceEl.value !== '1') {
                e.preventDefault();
                alert('Anda berada di luar area kerja. Presensi diblokir sesuai kebijakan.');
            }
        });
    })();
</script>
@endpush

@endsection
