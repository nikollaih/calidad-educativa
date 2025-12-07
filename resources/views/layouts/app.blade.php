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
        <style>
            .light-style .menu .app-brand.demo {height: 80px !important;}

            /* Hacer visible el botón de toggle en todas las pantallas */
            .layout-menu-toggle {
                display: block !important;
            }

            /* Mostrar logo completo cuando el menú está expandido */
            #layout-menu:not(.layout-menu-collapsed) .logo-full {
                display: block;
            }
            #layout-menu:not(.layout-menu-collapsed) .logo-collapsed {
                display: none;
            }

            /* Mostrar favicon cuando el menú está colapsado */
            #layout-menu.layout-menu-collapsed .logo-full {
                display: none;
            }
            #layout-menu.layout-menu-collapsed .logo-collapsed {
                display: block;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
    @php
        $municipios = session('municipios');
    @endphp
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                    <div class="app-brand demo justify-content-center">
                        <a href="{{  url('dashboard') }}" class="app-brand-link">
                            <!-- Logo completo para menú expandido -->
                            <img src="{{asset('imagenes/educacion_menu-nobg.png')}}"
                                 class="logo-full"
                                 width="190px"
                                 height="70"
                                 alt="Logo">
                            <!-- Favicon para menú colapsado -->
                            <img src="{{asset('favicon.png')}}"
                                 class="logo-collapsed"
                                 width="40px"
                                 height="40"
                                 alt="Logo Pequeño">
                        </a>
                    </div>
                    <div class="menu-divider mt-0"></div>
                    <div class="menu-inner-shadow"></div>
                    <ul class="menu-inner py-1">
                       @if(auth()->user()->can('hr-usuario-ver') || auth()->user()->can('s-role-ver') || auth()->user()->can('s-permission-ver'))
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons fa fa-building"></i>
                                <div data-i18n="Administracion">Administracion</div>
                            </a>
                            <ul class="menu-sub">
                                @can('hr-usuario-ver')
                                <li class="menu-item">
                                    <a href="{{ url('usuarios')}}" class="menu-link gap-2">
                                        <i class="menu-icon fa-solid fa-users"></i>
                                        <div data-i18n="Usuarios"> Usuarios</div>
                                    </a>
                                </li>
                                @endcan
                                @can('s-role-ver')
                                <li class="menu-item">
                                    <a href="{{ url('roles')}}" class="menu-link gap-2">
                                        <i class="menu-icon fa-solid fa-cogs"></i>
                                        <div data-i18n="Roles"> Roles</div>
                                    </a>
                                </li>
                                @endcan
                                @can('s-permission-ver')
                                <li class="menu-item">
                                    <a href="{{ url('permissions')}}" class="menu-link gap-2">
                                        <i class="menu-icon fa-solid fa-check"></i>
                                        <div data-i18n="Permisos"> Permisos</div>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                    @can('s-institucion-ver')
                        <li class="menu-item">
                            @if ($municipios)
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon fa-solid fa-university"></i>
                                <div data-i18n="Instituciones">Instituciones</div>
                            </a>
                            <ul class="menu-sub">
                                <ul>
                                    <li class="menu-item">
                                        <a href="{{ url('institutional_profile/institution')}}"
                                            class="menu-link gap-2"
                                        >
                                            <i class="menu-icon fas fa-globe-americas"></i>
                                            <div data-i18n="Todos"> Todos</div>
                                        </a>
                                    </li>
                                    @foreach ($municipios as $municipio)
                                        <li class="menu-item">
                                            <a href="{{ url('institutional_profile/institution?municipio_id='.$municipio->id)}}"
                                                class="menu-link gap-2"
                                            >
                                                <i class="menu-icon fas fa-map-marker-alt"></i>
                                                <div data-i18n="{{$municipio->nombre}}"> {{$municipio->nombre}}</div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <a href="{{ url('institutional_profile/institution')}}" class="menu-link gap-2">
                                    <i class="menu-icon fa-solid fa-university"></i>
                                    <div data-i18n="Instituciones">Instituciones</div>
                                </a>
                            @endif
                            </ul>
                        </li>
                    @endcan
                    @if(auth()->user()->can('s-parametro-editar'))
                        <li class="menu-item">
                            <a href="javascript:void(0);" class="menu-link  menu-toggle">
                                <i class="menu-icon fas fa-wrench"></i>
                                <div data-i18n="Parámetros">Parámetros</div>
                            </a>
                            <ul class="menu-sub">
                                @can('s-parametro-editar')
                                <li class="menu-item">
                                    <a href="{{ url('municipios')}}" class="menu-link gap-2">
                                        <i class="menu-icon fas fa-map"></i>
                                        <div data-i18n="Municipios"> Municipios</div>
                                    </a>
                                </li>
                                @endcan
                                @can('s-parametro-editar')
                                <li class="menu-item">
                                    <a href="{{ url('ajustes')}}" class="menu-link gap-2">
                                        <i class="menu-icon fa-solid fa-gears"></i>
                                        <div data-i18n="Ajustes de la página"> Ajustes de la página"</div>
                                    </a>
                                </li>
                                @endcan
                                @can('s-parametro-editar')
                                <li class="menu-item">
                                    <a href="{{ url('modelos-educacionales')}}" class="menu-link gap-2">
                                        <i class="menu-icon fas fa-lightbulb"></i>
                                        <div data-i18n="Modelos flexibles"> Modelos flexibles</div>
                                    </a>
                                </li>
                                @endcan
                                @can('s-parametro-editar')
                                <li class="menu-item">
                                    <a href="{{ url('modelos-pedagogicos')}}" class="menu-link gap-2">
                                        <i class="menu-icon fas fa-chalkboard-teacher"></i>
                                        <div data-i18n="Estrategias pedagógicas"> Estrategias pedagógicas</div>
                                    </a>
                                </li>
                                @endcan
                                @can('s-parametro-editar')
                                <li class="menu-item">
                                    <a href="{{ url('redes-aprendizajes')}}" class="menu-link gap-2">
                                        <i class="menu-icon fas fa-graduation-cap"></i>
                                        <div data-i18n="Redes de aprendizaje"> Redes de aprendizaje</div>
                                    </a>
                                </li>
                                @endcan
                                @can('s-parametro-editar')
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link gap-2 menu-toggle">
                                        <i class="menu-icon fas fa-clipboard-list"></i>
                                        <div data-i18n="PAM"> PAM</div>
                                    </a>
                                    <ul class="menu-sub">
                                        @can('s-parametro-editar')
                                        <li class="menu-item">
                                            <a href="{{ url('unidades-meta')}}" class="menu-link gap-2">
                                                <i class="menu-icon fas fa-bullseye"></i>
                                                <div data-i18n="Indicadores"> Indicadores</div>
                                            </a>
                                        </li>
                                        @endcan
                                        @can('s-parametro-editar')
                                        <li class="menu-item">
                                            <a href="{{ url('componentes')}}" class="menu-link gap-2">
                                                <i class="menu-icon fas fa-bullseye"></i>
                                                <div data-i18n="Componentes"> Componentes</div>
                                            </a>
                                        </li>
                                        @endcan
                                    </ul>
                                </li>
                                @endif
                                @if(auth()->user()->can('s-parametro-editar'))
                                <li class="menu-item">
                                    <a href="javascript:void(0);" class="menu-link gap-2 menu-toggle">
                                        <i class="menu-icon fas fa-shapes"></i>
                                        <div data-i18n="PMI">PMI</div>
                                    </a>
                                    <ul class="menu-sub">
                                        @can('s-parametro-editar')
                                        <li class="menu-item">
                                            <a  href="{{ url('objetivo-pmi')}}" class="menu-link gap-2">
                                                <i class="menu-icon fas fa-bullseye"></i>
                                                <div data-i18n="Objetivos"> Objetivos</div>
                                            </a>
                                        </li>
                                        @endcan
                                        @can('s-parametro-editar')
                                        <li class="menu-item">
                                            <a  href="{{ url('indicadores-pmi')}}" class="menu-link gap-2">
                                                <i class="menu-icon fas fa-ruler-horizontal"></i>
                                                <div data-i18n="Indicadores"> Indicadores</div>
                                            </a>
                                        </li>
                                        @endcan
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @can('s-pam-gestionar')
                        <li class="menu-item">
                            <a href="{{ url('pams/index')}}" class="menu-link ">
                                <i class="menu-icon fa-solid fa-table"></i>
                                <div data-i18n="PAM"> PAM</div>
                            </a>
                        </li>
                        @endcan
                        @can('s-red-actividad-ver')
                        <li class="menu-item">
                            <a href="{{ url('red-actividades')}}" class="menu-link">
                                <i class="menu-icon fa fa-graduation-cap"></i>
                                <div data-i18n="Redes pedagógicas"> Redes pedagógicas</div>
                            </a>
                        </li>
                        @endcan
                    @endif
                    @can('s-pmi-validacion-ver')
                        <li class="menu-item">
                            <a href="{{ url('pmi/validacion')}}" class="menu-link ">
                                <i class="menu-icon fas fa-tasks"></i>
                                <div data-i18n="Validación de PMI">Validación de PMI</div>
                            </a>
                        </li>
                    @endcan
                        <li class="menu-item">
                                <a class="layout-menu-toggle menu-link " href="javascript:void(0)">
                                    <i class="bx bx-menu bx-sm"></i>
                                </a>
                        </li>

                    </ul>
                </aside>
                <div class="layout-page">
                    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                        <div class="container-fluid">
                            <!-- Botón de toggle visible en todas las pantallas -->
                            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0">
                                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                    <i class="bx bx-menu bx-sm"></i>
                                </a>
                            </div>
                            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                                <ul class="navbar-nav flex-row align-items-center ms-auto">
                                    <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                            <div class="avatar avatar-online">
                                                    <img src="{{asset('assets/img/avatars/1.png')}}" alt class="rounded-circle" />
                                            </div>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{asset('profile')}}">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar avatar-online">
                                                                @if( session('icono') )
                                                                    <img src="{{asset('storage/iconos/')}}/{{session('icono')}}" alt class="rounded-circle" />
                                                                @else
                                                                    <img src="{{asset('assets/img/avatars/1.png')}}" alt class="rounded-circle" />
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="fw-semibold d-block lh-1">
                                                                {{ Auth::user() ? Auth::user()->name : 'Sin Perfil' }}
                                                            </span>

                                                            <ul class="list-unstyled small mb-0 mt-1">
                                                                @if (Auth::check() && Auth::user()->roles->isNotEmpty())
                                                                    @foreach (Auth::user()->roles as $role)
                                                                        <li>{{ $role->name_translated ?? $role->name }}</li>
                                                                    @endforeach
                                                                @else
                                                                    <li>Sin Rol</li>
                                                                @endif
                                                            </ul>
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
                                                       Cerrar sesión
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
                               <!-- <div class="mb-2 mb-md-0"> © <script>document.write(new Date().getFullYear());</script> by Developers
                               </div> -->
                            </div>
                        </footer>
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>
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
        <script>
            // Script para cambiar el logo cuando el menú se colapsa
            $(document).ready(function() {
                // Función para actualizar el logo basado en el ancho del menú
                function updateLogo() {
                    var layoutMenu = $('#layout-menu');
                    var menuWidth = layoutMenu.width();

                    // Debug: imprimir en consola

                    // Si el menú tiene menos de 100px de ancho, está colapsado
                    if (menuWidth < 100) {
                        $('.logo-full').hide();
                        $('.logo-collapsed').show();
                    } else {
                        $('.logo-full').show();
                        $('.logo-collapsed').hide();
                    }
                }

                // Ejecutar al cargar la página
                setTimeout(updateLogo, 500);

                // Detectar clicks en el botón de toggle
                $(document).on('click', '.layout-menu-toggle', function(e) {
                    setTimeout(updateLogo, 350);
                });

                // Observar cambios en el tamaño del menú
                if (window.ResizeObserver) {
                    const resizeObserver = new ResizeObserver(function(entries) {
                        updateLogo();
                    });

                    var menuElement = document.getElementById('layout-menu');
                    if (menuElement) {
                        resizeObserver.observe(menuElement);
                    }
                }

                // Verificar cada segundo durante los primeros 5 segundos (por si acaso)
                for (let i = 1; i <= 5; i++) {
                    setTimeout(updateLogo, i * 1000);
                }
            });
        </script>
        <script>
            window.auth = {
                user: {!! Auth::check() ? json_encode(Auth::user()->only(['id', 'name', 'email'])) : 'null' !!},
                permissions: {!! Auth::check() ? json_encode(Auth::user()->getAllPermissions()->pluck('name')) : '[]' !!},
                roles: {!! Auth::check() ? json_encode(Auth::user()->roles->pluck('name')) : '[]' !!}
            };
        </script>
        @yield('javascripts')
    </body>
</html>
