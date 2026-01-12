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
            <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="card-header">
                                @if (Session::has('flash_error_message'))
                                    <div class="alert alert-danger" role="alert">{{ Session::get('flash_error_message') }}</div>
                                @endif
                                @if (Session::has('flash_success_message'))
                                    <div class="alert alert-success" role="alert">{{ Session::get('flash_success_message') }}</div>
                                @endif
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @yield('content')
                        </div>
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                               <!-- <div class="mb-2 mb-md-0"> © <script>document.write(new Date().getFullYear());</script> by Developers
                               </div> -->
                            </div>
                        </footer>
            <!-- Content backdrop -->
            <div class="absolute inset-0 bg-black bg-opacity-50 z-0 hidden" id="content-backdrop"></div>
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
