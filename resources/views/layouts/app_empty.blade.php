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
        <!--<script src="{{asset('assets/js/forms-editors-pei.js')}}"></script> -->

        <style>.light-style .menu .app-brand.demo {height: 80px !important;}</style>
    </head>

    <body>
        <script src="{{ asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/popper/popper.js')}}"></script>
        <script src="{{ asset('assets/vendor/js/bootstrap.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/i18n/i18n.js')}}"></script>
        <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
        <script src="{{ asset('assets/vendor/js/menu.js')}}"></script>

        @yield('vendors_js')
        <script src="{{ asset('assets/js/main.js')}}"></script>

        @yield('javascripts')
    </body>
</html>


