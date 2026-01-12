<!DOCTYPE html>
<html
        lang="en"
        class="light-style layout-navbar-fixed layout-menu-fixed"
        dir="ltr"
        data-theme="theme-default"
        data-assets-path="{{asset('assets')}}/"
        data-path="{{url('/')}}"
        data-template="vertical-menu-template-no-customizer">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
        <title>{{ env('APP_NAME') }}</title>
        <meta name="description" content="" />
        <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon/favicon.ico')}}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">
        @vite(['resources/css/app.css'])
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css') }}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css') }}" />
        <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/typography.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/katex.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/quill/editor.css')}}" />
        @yield('vendors_css')
        <!-- Custom CSS -->
        @yield('custom_css')
        @vite('resources/js/app.js')
        <script src="{{asset('assets/vendor/libs/quill/quill.js')}}"></script>
        <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
        <script src="{{asset('assets/js/config.js')}}"></script>
    </head>
    <body>
    @php
        $municipios = session('municipios');
    @endphp
    <div class="flex h-screen overflow-hidden bg-custom-gray-light">
        <!-- Sidebar component -->
        @include('layouts.app.sidebar')
        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            @include('layouts.app.navbar')
            <div class="flex flex-col min-h-screen">
                <!-- Content Wrapper con scroll -->
                <div class="flex-1 flex flex-col overflow-hidden">
                    <!-- Contenedor principal con scroll vertical -->
                    <div class="flex-1 overflow-y-auto">
                        <div class="container mx-auto px-4 py-6 max-w-7xl">
                            <!-- Header con mensajes -->
                            <div class="mb-6">
                                @if (Session::has('flash_error_message'))
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <span class="block sm:inline">{{ Session::get('flash_error_message') }}</span>
                                    </div>
                                @endif

                                @if (Session::has('flash_success_message'))
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <span class="block sm:inline">{{ Session::get('flash_success_message') }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Errores de validación -->
                            @if ($errors->any())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Contenido principal -->
                            <div class="pb-6">
                                @yield('content')
                            </div>
                        </div>
                    </div>

                    <!-- Footer fijo en la parte inferior -->
                    <footer class="bg-gray-50 border-t border-gray-200 flex-shrink-0">
                        <div class="container mx-auto px-4 py-3 flex flex-wrap justify-between items-center max-w-7xl">
                            <div class="text-sm text-gray-600">
                                <!-- © <script>document.write(new Date().getFullYear());</script> by Developers -->
                            </div>
                        </div>
                    </footer>
                </div>

                <!-- Content backdrop -->
                <div class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden" id="content-backdrop"></div>
            </div>
    </div>
        <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/i18n/i18n.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
        <script>
            window.auth = {
                user: {!! Auth::check() ? json_encode(Auth::user()->only(['id', 'name', 'email'])) : 'null' !!},
                permissions: {!! Auth::check() ? json_encode(Auth::user()->getAllPermissions()->pluck('name')) : '[]' !!},
                roles: {!! Auth::check() ? json_encode(Auth::user()->roles->pluck('name')) : '[]' !!}
            };
        </script>
        <script>

        </script>
        @yield('javascripts')
    </body>
</html>
