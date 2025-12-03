<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIMPEG RS - Secure Access</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    animation: {
                        'grid-move': 'gridMove 20s linear infinite',
                        'pulse-glow': 'pulseGlow 3s infinite',
                        'float-slow': 'floatSlow 8s ease-in-out infinite',
                        'float-medium': 'floatMedium 6s ease-in-out infinite',
                        'spin-slow': 'spinSlow 15s linear infinite',
                        'rise': 'rise 10s infinite linear',
                    },
                    keyframes: {
                        gridMove: {
                            '0%': { backgroundPosition: '0 0' },
                            '100%': { backgroundPosition: '40px 40px' },
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 30px -5px rgba(14, 165, 233, 0.3)' },
                            '50%': { boxShadow: '0 0 50px -5px rgba(14, 165, 233, 0.6)' },
                        },
                        floatSlow: {
                            '0%, 100%': { transform: 'translateY(0) rotate(0deg)' },
                            '50%': { transform: 'translateY(-30px) rotate(5deg)' },
                        },
                        floatMedium: {
                            '0%, 100%': { transform: 'translateY(0) translateX(0)' },
                            '50%': { transform: 'translateY(-20px) translateX(20px)' },
                        },
                        spinSlow: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' },
                        },
                        rise: {
                            '0%': { bottom: '-10%', opacity: '0' },
                            '20%': { opacity: '0.6' },
                            '80%': { opacity: '0.6' },
                            '100%': { bottom: '110%', opacity: '0' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .tech-bg {
            background-color: #020617; /* Slate 950 */
            background-image: 
                linear-gradient(rgba(56, 189, 248, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56, 189, 248, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 25s linear infinite;
        }

        .neon-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(56, 189, 248, 0.3);
            box-shadow: 0 0 30px -5px rgba(14, 165, 233, 0.25), inset 0 0 20px -10px rgba(14, 165, 233, 0.2);
            transition: all 0.4s ease-in-out;
        }

        .neon-card:hover {
            border-color: rgba(56, 189, 248, 0.8);
            box-shadow: 0 0 60px -5px rgba(14, 165, 233, 0.5), inset 0 0 30px -5px rgba(14, 165, 233, 0.3);
            transform: translateY(-5px);
        }

        .input-tech {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(148, 163, 184, 0.2);
            color: white;
            transition: all 0.3s;
        }
        .input-tech:focus {
            background: rgba(14, 165, 233, 0.1);
            border-color: #38bdf8;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.3);
        }
        
        /* Objek Shape SVG */
        .shape-svg {
            position: absolute;
            fill: none;
            stroke-width: 2;
            opacity: 0.15; /* Transparan halus */
        }
    </style>
</head>
<body class="tech-bg h-screen w-full flex items-center justify-center overflow-hidden relative text-white">

    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        
        <svg class="shape-svg stroke-cyan-500 w-64 h-64 top-10 left-10 animate-spin-slow" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5v9l9 5.25 9-5.25v-9z" />
        </svg>

        <svg class="shape-svg stroke-blue-500 w-48 h-48 bottom-20 right-20 animate-float-slow" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>

        <svg class="shape-svg stroke-indigo-500 w-32 h-32 top-1/2 left-20 animate-float-medium" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" />
        </svg>
        
        <div class="absolute top-20 right-32 w-20 h-20 border-2 border-cyan-500/20 rounded-xl animate-float-slow rotate-45"></div>

        <div class="absolute left-[10%] w-2 h-2 bg-blue-500 rounded-full animate-rise" style="animation-duration: 7s;"></div>
        <div class="absolute left-[30%] w-3 h-3 bg-cyan-500 rounded-full animate-rise" style="animation-duration: 12s; animation-delay: 2s;"></div>
        <div class="absolute left-[70%] w-2 h-2 bg-indigo-500 rounded-full animate-rise" style="animation-duration: 9s; animation-delay: 1s;"></div>
        <div class="absolute left-[90%] w-4 h-4 bg-blue-400 rounded-full animate-rise opacity-20" style="animation-duration: 15s; animation-delay: 0s;"></div>

    </div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[100px] pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-[400px] px-4">
        
        <div class="neon-card rounded-2xl p-8 w-full animate-pulse-glow hover:animate-none">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-500/10 border border-blue-400/30 mb-4 shadow-[0_0_20px_rgba(59,130,246,0.3)]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-blue-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white tracking-tight drop-shadow-md">SIMPEG RS</h2>
                <p class="text-blue-200/70 text-sm mt-2">Login Secure System</p>
            </div>
            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-200 text-sm text-center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-blue-300 uppercase mb-2 tracking-wider">NIP / ID / EMAIL</label>
                    <input type="text" name="identity" required autofocus
                        class="input-tech w-full px-4 py-3 rounded-xl focus:outline-none"
                        placeholder="Contoh: 1998200...">
                </div>

                <div>
                    <label class="block text-xs font-bold text-blue-300 uppercase mb-2 tracking-wider">Password</label>
                    <input type="password" name="password" required
                        class="input-tech w-full px-4 py-3 rounded-xl focus:outline-none"
                        placeholder="••••••••">
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-bold rounded-xl shadow-[0_0_20px_rgba(56,189,248,0.5)] hover:shadow-[0_0_35px_rgba(56,189,248,0.8)] transform hover:-translate-y-1 transition-all duration-300">
                    MASUK SISTEM
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-slate-500 font-mono">
                    SECURE CONNECTION ENCRYPTED
                </p>
            </div>
        </div>
    </div>

</body>
</html>