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
            @include('layouts.sneat-sidebar')

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

    @stack('scripts')
</body>
</html>
