<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal SIMPEG RS - Integrated HR System</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    animation: {
                        'grid-move': 'gridMove 30s linear infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in-up': 'fadeInUp 1s ease-out forwards',
                    },
                    keyframes: {
                        gridMove: {
                            '0%': { backgroundPosition: '0 0' },
                            '100%': { backgroundPosition: '50px 50px' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .tech-bg {
            background-color: #020617; 
            background-image: 
                linear-gradient(rgba(56, 189, 248, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56, 189, 248, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 30s linear infinite;
        }

        .glass-nav {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(56, 189, 248, 0.1);
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s;
        }

        .glass-card:hover {
            background: rgba(30, 41, 59, 0.6);
            border-color: rgba(56, 189, 248, 0.5);
            transform: translateY(-5px);
            box-shadow: 0 10px 40px -10px rgba(14, 165, 233, 0.3);
        }

        .btn-glow {
            box-shadow: 0 0 15px rgba(14, 165, 233, 0.4);
            transition: all 0.3s;
        }
        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(14, 165, 233, 0.7);
        }
    </style>
</head>
<body class="tech-bg text-white min-h-screen flex flex-col relative overflow-x-hidden">

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-cyan-500/10 rounded-full blur-[100px]"></div>
        
        <svg class="absolute top-20 left-20 w-32 h-32 stroke-blue-500/20 animate-float" viewBox="0 0 24 24" fill="none" stroke-width="1">
             <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5v9l9 5.25 9-5.25v-9z" />
        </svg>
    </div>

    <nav class="glass-nav fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">SIMPEG RS</h1>
                        <p class="text-[10px] text-blue-300 uppercase tracking-widest">Sistem Kepegawaian Terpadu</p>
                    </div>
                </div>
                <div>
                    <a href="{{ route('login.simpeg') }}" class="px-5 py-2.5 rounded-full border border-blue-500/30 text-sm font-semibold hover:bg-blue-500/10 transition text-blue-300 hover:text-white">
                        Akses Pegawai
                    </a>
                </div>
            </div>
        </div> 
    </nav>

    <main class="flex-grow flex items-center justify-center pt-20 px-4 relative z-10">
        <div class="max-w-5xl mx-auto text-center">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-300 text-xs font-medium mb-6 animate-fade-in-up">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                System Operational v2.0
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 bg-clip-text text-transparent bg-gradient-to-r from-white via-blue-100 to-slate-400 animate-fade-in-up" style="animation-delay: 0.1s;">
                Transformasi Digital <br>
                <span class="text-blue-500">Manajemen Rumah Sakit</span>
            </h1>

            <p class="text-lg text-slate-400 max-w-2xl mx-auto mb-10 animate-fade-in-up" style="animation-delay: 0.2s;">
                Platform terintegrasi untuk pengelolaan data pegawai, kinerja, remunerasi, dan administrasi Rumah Sakit yang aman, cepat, dan transparan.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up" style="animation-delay: 0.3s;">
                <a href="{{ route('login.simpeg') }}" class="btn-glow px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-xl font-bold text-lg flex items-center gap-2 hover:-translate-y-1 transform transition">
                    <span>Login ke Sistem</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                
                <a href="#" class="px-8 py-4 rounded-xl border border-slate-700 font-semibold text-slate-300 hover:bg-slate-800 transition hover:text-white">
                    Panduan Penggunaan
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-20 text-left animate-fade-in-up" style="animation-delay: 0.5s;">
                
                <div class="glass-card p-6 rounded-2xl">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mb-4 text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Data Kepegawaian</h3>
                    <p class="text-sm text-slate-400">Akses data diri, riwayat pangkat, dan berkas digital secara real-time.</p>
                </div>

                <div class="glass-card p-6 rounded-2xl">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4 text-purple-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">E-Kinerja</h3>
                    <p class="text-sm text-slate-400">Pelaporan aktivitas harian dan penilaian kinerja pegawai terintegrasi.</p>
                </div>

                <div class="glass-card p-6 rounded-2xl">
                    <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center mb-4 text-cyan-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Pusat Bantuan</h3>
                    <p class="text-sm text-slate-400">Layanan support IT dan panduan teknis jika mengalami kendala akses.</p>
                </div>

            </div>

        </div>
    </main>

    <footer class="border-t border-slate-800 bg-slate-900/50 backdrop-blur-sm mt-20 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} Instalasi Teknologi Informasi Rumah Sakit. All rights reserved. <br>
                <span class="text-xs text-slate-600">Secure connection encrypted via SSL/TLS</span>
            </p>
        </div>
    </footer>

</body>
</html>