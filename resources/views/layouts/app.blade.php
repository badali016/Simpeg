<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>{{ config('app.name', 'Simpeg') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Sneat CSS --}}
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    @include('components.neon-styles')
</head>

<body>
    @include('components.neon-bg')
    <div class="layout-wrapper layout-content-navbar relative" style="z-index: 1;">
        <div class="layout-container">
            {{-- SIDEBAR --}}
            @auth
                @if(auth()->user()->is_admin)
                    @include('layouts.sneat-sidebar')
                @elseif(auth()->user()->pegawai_id)
                    @include('layouts.pegawai-sidebar')
                @else
                    @include('layouts.sneat-sidebar')
                @endif
            @else
                @include('layouts.sneat-sidebar')
            @endauth

            <div class="layout-page">
                {{-- NAVBAR --}}
                @include('layouts.sneat-navbar')

                <div class="content-wrapper">
                    {{-- CONTENT DINAMIS --}}
                    <div class="container-xxl grow container-p-y">
                        @yield('content')
                    </div>

                    {{-- FOOTER SINGKAT --}}
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                &copy; {{ date('Y') }} {{ config('app.name', 'Simpeg') }}
                            </div>
                        </div>
                    </footer>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>

            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
    </div>

    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>

    {{-- Toast container for flash messages --}}
    <div id="flash-toasts" style="position:fixed;right:10px;bottom:10px;z-index:9999;display:flex;flex-direction:column;align-items:flex-end;gap:8px;max-width:calc(100vw - 20px);"></div>
    
    <style>
        @media (min-width: 640px) {
            #flash-toasts {
                right: 20px;
                bottom: 20px;
                max-width: 400px;
            }
        }
        
        .toast {
            font-size: 14px;
            max-width: 100%;
            word-wrap: break-word;
        }
        
        @media (max-width: 639px) {
            .toast {
                font-size: 13px;
                padding: 12px 16px !important;
            }
        }
    </style>

    <script>
        (function () {
            function showToast(type, msg) {
                var el = document.createElement('div');
                el.className = 'toast px-4 py-2 rounded shadow-lg';
                var bg = '#374151';
                if (type === 'success') bg = '#10B981';
                if (type === 'error') bg = '#EF4444';
                if (type === 'info') bg = '#3B82F6';
                if (type === 'warning') bg = '#F59E0B';
                el.style.background = bg;
                el.style.color = '#fff';
                el.style.marginTop = '0';
                el.style.opacity = '1';
                el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                el.style.transform = 'translateY(0)';
                el.textContent = msg;
                var container = document.getElementById('flash-toasts');
                container.appendChild(el);
                // Auto-hide after 4s
                setTimeout(function () { el.style.opacity = '0'; el.style.transform = 'translateY(10px)'; setTimeout(function(){ el.remove(); }, 450); }, 4000);
            }

            // Helper to escape backticks/newlines
            function esc(s) { return String(s).replace(/\r|\n/g, ' ').replace(/"/g, '\\"'); }

            // Inject server flash messages
            @if(session('success'))
                showToast('success', "{{ addslashes(session('success')) }}");
            @endif
            @if(session('error'))
                showToast('error', "{{ addslashes(session('error')) }}");
            @endif
            @if(session('info'))
                showToast('info', "{{ addslashes(session('info')) }}");
            @endif
            @if(session('warning'))
                showToast('warning', "{{ addslashes(session('warning')) }}");
            @endif

            @if(isset($errors) && $errors->any())
                showToast('error', "{{ addslashes($errors->first()) }}");
            @endif
        })();
    </script>

    @stack('scripts')
</body>
</html>
