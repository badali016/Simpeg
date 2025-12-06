@extends('layouts.app')

@section('content')
    @include('components.neon-styles')
    
    <!-- Welcome Header -->
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 mb-2">Dashboard Admin</h1>
        <p class="text-sm sm:text-base text-slate-600">Ringkasan data dan statistik sistem</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Total Pegawai Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 text-white border-2 border-blue-400 hover:scale-105 transition">
            <div class="flex items-center justify-between mb-3 md:mb-4">
                <div>
                    <p class="text-blue-100 text-xs md:text-sm font-medium mb-1">Total Pegawai</p>
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold">{{ $totalPegawai }}</h3>
                </div>
                <div class="w-12 h-12 md:w-16 md:h-16 bg-white/20 rounded-xl md:rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-7 h-7 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-blue-100 text-xs md:text-sm">
                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">Pegawai Aktif</span>
            </div>
        </div>

        <!-- Total Jabatan Card -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 text-white border-2 border-emerald-400 hover:scale-105 transition">
            <div class="flex items-center justify-between mb-3 md:mb-4">
                <div>
                    <p class="text-emerald-100 text-xs md:text-sm font-medium mb-1">Total Jabatan</p>
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold">{{ $totalJabatan }}</h3>
                </div>
                <div class="w-12 h-12 md:w-16 md:h-16 bg-white/20 rounded-xl md:rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-7 h-7 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-emerald-100 text-xs md:text-sm">
                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">Posisi Tersedia</span>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 text-white border-2 border-purple-400 hover:scale-105 transition">
            <div class="flex items-center justify-between mb-3 md:mb-4">
                <div>
                    <p class="text-purple-100 text-xs md:text-sm font-medium mb-1">Total Users</p>
                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-extrabold">{{ $totalUsers }}</h3>
                </div>
                <div class="w-12 h-12 md:w-16 md:h-16 bg-white/20 rounded-xl md:rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-7 h-7 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-purple-100 text-xs md:text-sm">
                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">Akun Sistem</span>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 border-2 border-slate-300">
            <div class="mb-3 md:mb-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-100 rounded-lg md:rounded-xl flex items-center justify-center mb-2 md:mb-3">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <p class="text-slate-600 text-xs md:text-sm font-medium mb-2 md:mb-3">Quick Actions</p>
            </div>
            <div class="space-y-2">
                <a href="{{ route('admin.pegawai.create') }}" class="flex items-center justify-center px-3 md:px-4 py-2.5 md:py-2.5 min-h-[44px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transition font-semibold text-xs md:text-sm">
                    <svg class="w-4 h-4 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pegawai
                </a>
                <a href="{{ route('admin.jabatan.create') }}" class="flex items-center justify-center px-3 md:px-4 py-2.5 md:py-2.5 min-h-[44px] bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-md transition font-semibold text-xs md:text-sm">
                    <svg class="w-4 h-4 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Jabatan
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-6 md:mb-8">
        <!-- Pegawai Chart -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 border-2 border-slate-300">
            <div class="flex items-center mb-4 md:mb-6">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-lg md:rounded-xl flex items-center justify-center mr-2 md:mr-3">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-base md:text-lg font-bold text-slate-900">Distribusi Pegawai</h3>
            </div>
            <div class="h-48 sm:h-56 md:h-64 relative">
                <canvas id="pegawaiChart"></canvas>
            </div>
        </div>

        <!-- Status Chart -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl p-4 md:p-6 border-2 border-slate-300">
            <div class="flex items-center mb-4 md:mb-6">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-emerald-100 rounded-lg md:rounded-xl flex items-center justify-center mr-2 md:mr-3">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <h3 class="text-base md:text-lg font-bold text-slate-900">Status Pegawai</h3>
            </div>
            <div class="h-48 sm:h-56 md:h-64 relative">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Pegawai Table -->
    <div class="bg-white rounded-xl md:rounded-2xl shadow-lg md:shadow-xl overflow-hidden border-2 border-slate-300">
        <div class="px-4 md:px-6 py-4 md:py-5 border-b-2 border-slate-200 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-slate-600 rounded-lg md:rounded-xl flex items-center justify-center mr-2 md:mr-3">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base md:text-xl font-bold text-slate-900">Pegawai Terbaru</h3>
                </div>
                <a href="{{ route('admin.pegawai.index') }}" class="px-3 md:px-4 py-2 min-h-[40px] flex items-center bg-slate-600 hover:bg-slate-700 text-white rounded-lg text-xs md:text-sm font-semibold transition shadow-md">
                    Lihat Semua
                </a>
            </div>
        </div>
        <div class="overflow-x-auto -mx-4 md:mx-0">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Nama</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">NIP</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Jabatan</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($recentPegawais as $p)
                    @php
                        if (is_object($p)) {
                            $pKey = $p->id ?? ($p->ID ?? (method_exists($p, 'getKey') ? $p->getKey() : null));
                            $pName = $p->nama ?? $p->nama_pegawai ?? $p->NAMA ?? '-';
                            $pJabatan = $p->profesi_nama ?? ($p->profesi ?? ($p->jabatan?->nama_jabatan ?? ($p->jabatan_nama ?? '-')));
                        } else {
                            $pKey = $p; $pName = '-'; $pJabatan = '-';
                        }
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                            <a href="{{ route('admin.pegawai.show', $pKey) }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline text-xs md:text-sm">{{ $pName }}</a>
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-xs md:text-sm font-medium text-slate-700 whitespace-nowrap">{{ $p->nip ?? ($p->NIP ?? '-') }}</td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-xs md:text-sm font-medium text-slate-600 whitespace-nowrap">{{ $pJabatan }}</td>
                        @php
                            $pStatusVal = $p->status ?? $p->STATUS ?? null;
                            $pStatusLabel = is_null($pStatusVal) ? '-' : (is_numeric($pStatusVal) ? ($pStatusVal ? 'Aktif' : 'Tidak Aktif') : $pStatusVal);
                        @endphp
                        <td class="px-3 md:px-6 py-3 md:py-4 whitespace-nowrap">
                            @if($pStatusLabel == 'Aktif')
                                <span class="px-2 md:px-3 py-1 md:py-1.5 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-300">{{ $pStatusLabel }}</span>
                            @else
                                <span class="px-2 md:px-3 py-1 md:py-1.5 rounded-lg text-xs font-bold bg-red-100 text-red-700 border border-red-300">{{ $pStatusLabel }}</span>
                            @endif
                        </td>
                        <td class="px-3 md:px-6 py-3 md:py-4 text-right whitespace-nowrap">
                            <a href="{{ route('admin.pegawai.edit', $pKey) }}" class="inline-flex items-center px-2 md:px-3 py-1.5 min-h-[36px] bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg text-xs md:text-sm font-semibold transition border border-indigo-300">
                                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="px-3 md:px-6 py-8 md:py-12 text-center" colspan="5">
                            <svg class="w-12 h-12 md:w-16 md:h-16 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-sm md:text-base text-slate-500 font-semibold">Belum ada data pegawai</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pegawai Distribution Chart
    const pegawaiCtx = document.getElementById('pegawaiChart');
    if (pegawaiCtx) {
        new Chart(pegawaiCtx, {
            type: 'bar',
            data: {
                labels: ['Pegawai', 'Jabatan', 'Users'],
                datasets: [{
                    label: 'Total',
                    data: [{{ $totalPegawai }}, {{ $totalJabatan }}, {{ $totalUsers }}],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(139, 92, 246, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(139, 92, 246)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    }

    // Status Pie Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Aktif', 'Tidak Aktif'],
                datasets: [{
                    data: [{{ $totalPegawai }}, 0],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 13,
                                weight: 'bold'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                }
            }
        });
    }
});
</script>
@endpush