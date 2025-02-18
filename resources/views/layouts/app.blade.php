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
        
        @yield('vendors_css')
        
        <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
        <script src="{{asset('assets/js/config.js')}}"></script>
        <style>.light-style .menu .app-brand.demo {height: 80px !important;}</style>
    </head>

    <body>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                    <div class="app-brand demo">
                        <a href="{{  url('empleados') }}" class="app-brand-link">
                            <span class="app-brand-logo demo">
                                <svg
                                        width="26px"
                                        height="26px"
                                        viewBox="0 0 26 26"
                                        version="1.1"
                                        xmlns="{{asset('storage/iconos')}}/{{ session('icono') ? session('icono') : 'icono_empresa.png' }}"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>{{ env('APP_NAME') }}</title>
                                </svg>
                            </span>
                            <img src="{{asset('storage/logos')}}/{{ session('logo') ? session('logo') : 'logo_empresa.png' }}" width="170px;" alt="Logo">
                        </a>
                    </div>
                    <div class="menu-divider mt-0"></div>
                    <div class="menu-inner-shadow"></div>
                    <ul class="menu-inner py-1">
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons fa fa-building"></i>
                                <div data-i18n="Administracion">Administracion</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item">
                                    <a href="{{ url('usuarios')}}" class="menu-link">
                                        <i class="menu-icon fa-solid fa-users"></i>
                                        <div data-i18n="Usuarios"> Usuarios</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ url('roles')}}" class="menu-link">
                                        <i class="menu-icon fa-solid fa-cogs"></i>
                                        <div data-i18n="Roles"> Roles</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ url('permissions')}}" class="menu-link">
                                        <i class="menu-icon fa-solid fa-check"></i>
                                        <div data-i18n="Permisos"> Permisos</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </aside>
                <div class="layout-page">    
                    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                        <div class="container-fluid">
                            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                    <i class="bx bx-menu bx-sm"></i>
                                </a>
                            </div>

                            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                                <ul class="navbar-nav flex-row align-items-center ms-auto">
                                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <div class="avatar avatar-online">
                                                <img src="{{asset('storage/iconos')}}/{{session('icono') ?  session('icono') : 'icono_empresa.png'}}" alt class="rounded-circle" />
                                            </div>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="pages-account-settings-account.html">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar avatar-online">
                                                                @if( session('icono') )
                                                                    <img src="{{asset('storage/iconos/')}}/{{session('icono')}}" alt class="rounded-circle" />
                                                                @else
                                                                    <img src="../../assets/img/avatars/1.png" alt class="rounded-circle" />
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="fw-semibold d-block lh-1">{{ session('logo') ? session('logo') : 'Sin Perfil' }}</span>
                                                            <small>Admin</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider"></div>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="nav-link btn btn-link" style="cursor: pointer;">
                                                        Logout
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="navbar-search-wrapper search-input-wrapper d-none">
                                <input
                                        type="text"
                                        class="form-control search-input container-fluid border-0"
                                        placeholder="Search..."
                                        aria-label="Search..."
                                />
                                <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
                            </div>
                        </div>
                    </nav>
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
                                <div class="mb-2 mb-md-0"> © <script>document.write(new Date().getFullYear());</script> by Developers
                                </div>
                            </div>
                        </footer>
                        
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>

            <div class="layout-overlay layout-menu-toggle"></div>

            <div class="drag-target"></div>
        </div>
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


