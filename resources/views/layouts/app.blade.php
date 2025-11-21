<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Simpeg') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /*! tailwind fallback (compiled) included by welcome view */
        </style>
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen">
    <header class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h1 class="text-lg font-semibold">{{ config('app.name', 'Simpeg') }}</h1>
                <span class="text-sm text-[#706f6c]">Sistem Informasi Kepegawaian</span>
            </div>
            <nav class="text-sm">
                <a href="/" class="text-[#1b1b18] hover:underline mr-4">Home</a>
                <a href="{{ route('jabatan.index') }}" class="text-[#1b1b18] hover:underline mr-4">Jabatan</a>
                <a href="{{ route('pegawai.index') }}" class="text-[#1b1b18] hover:underline mr-4">Pegawai</a>
                <a href="{{ route('admin.dashboard') }}" class="text-[#1b1b18] hover:underline">Admin</a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded border border-green-100">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="max-w-6xl mx-auto px-4 py-6 text-sm text-[#706f6c]">
        &copy; {{ date('Y') }} {{ config('app.name', 'Simpeg') }}
    </footer>
</body>
</html>
