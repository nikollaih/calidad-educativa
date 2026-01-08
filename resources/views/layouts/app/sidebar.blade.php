@php
    use Illuminate\Support\Str;

    $sidebarMenu = [
        [
            'icon' => asset('assets/icon/location_city.svg'),
            'icon_type' => 'svg',
            'label' => 'Administración',
            'permission' => 'hr-usuario-ver|s-role-ver|s-permission-ver',
            'routes' => 'usuarios*|roles*|permissions*',
            'items' => [
                ['url' => 'usuarios', 'icon' => 'fa-solid fa-users', 'label' => 'Usuarios'],
                ['url' => 'roles', 'icon' => 'fa-solid fa-cogs', 'label' => 'Roles'],
                ['url' => 'permissions', 'icon' => 'fa-solid fa-check', 'label' => 'Permisos'],
            ]
        ],
        [
            'icon' => asset('assets/icon/account_balance.svg'),
            'icon_type' => 'svg',
            'label' => 'Instituciones',
            'permission' => 's-institucion-ver',
            'role' => 'rector',
            'routes' => 'institutional_profile*',
            'items' => [
                ['url' => 'institutional_profile/institution', 'icon' => 'fas fa-globe-americas', 'label' => 'Todos', 'exact' => true],
                ['dynamic' => 'municipios', 'url' => 'institutional_profile/institution?municipio_id=', 'icon' => 'fas fa-map-marker-alt']
            ]
        ],
        [
            'icon' => asset('assets/icon/build.svg'),
            'icon_type' => 'svg',
            'label' => 'Parámetros',
            'permission' => 's-parametro-editar',
            'routes' => 'municipios*|ajustes*|modelos*|redes*|unidades*|componentes*|objetivo*|indicadores*',
            'items' => [
                ['url' => 'municipios', 'icon' => 'fas fa-map', 'label' => 'Municipios'],
                ['url' => 'ajustes', 'icon' => 'fa-solid fa-gears', 'label' => 'Ajustes de la página'],
                ['url' => 'modelos-educacionales', 'icon' => 'fas fa-lightbulb', 'label' => 'Modelos flexibles'],
                ['url' => 'modelos-pedagogicos', 'icon' => 'fas fa-chalkboard-teacher', 'label' => 'Estrategias pedagógicas'],
                ['url' => 'redes-aprendizajes', 'icon' => 'fas fa-graduation-cap', 'label' => 'Redes de aprendizaje'],
                [
                    'label' => 'PAM',
                    'icon' => 'fas fa-clipboard-list',
                    'routes' => 'unidades*|componentes*',
                    'items' => [
                        ['url' => 'unidades-meta', 'icon' => 'fas fa-bullseye', 'label' => 'Indicadores'],
                        ['url' => 'componentes', 'icon' => 'fas fa-bullseye', 'label' => 'Componentes'],
                    ]
                ],
                [
                    'label' => 'PMI',
                    'icon' => 'fas fa-shapes',
                    'routes' => 'objetivo*|indicadores*',
                    'items' => [
                        ['url' => 'objetivo-pmi', 'icon' => 'fas fa-bullseye', 'label' => 'Objetivos'],
                        ['url' => 'indicadores-pmi', 'icon' => 'fas fa-ruler-horizontal', 'label' => 'Indicadores'],
                    ]
                ],
            ]
        ],
        [
            'url' => 'pams/index',
            'icon' => asset('assets/icon/calendar_month.svg'),
            'icon_type' => 'svg',
            'label' => 'PAM', 'permission' => 's-pam-consultar|s-pam-gestionar'
        ],
        [
            'url' => 'red-actividades',
            'icon' => asset('assets/icon/school.svg'),
            'icon_type' => 'svg',
            'label' => 'Redes pedagógicas',
            'permission' => 's-red-actividad-gestionar',
            'role' => 'rector'
        ],
        [
            'url' => 'pmi/validacion',
            'icon' => asset('assets/icon/list_alt_check.svg'),
            'icon_type' => 'svg',
            'label' => 'Validación de PMI',
            'permission' => 's-pmi-validar'
        ],
    ];

    $canView = fn($item) => match(true) {
        isset($item['permission']) => collect(explode('|', $item['permission']))->some(fn($p) => auth()->user()->can($p)),
        isset($item['role']) => auth()->user()->hasRole($item['role']),
        default => true
    };

    $isActive = fn($item) => match(true) {
        isset($item['exact']) => request()->fullUrlIs(url($item['url'])),
        default => collect(explode('|', $item['routes'] ?? $item['url'].'*'))->some(fn($r) => request()->is($r))
    };
@endphp

<aside id="layout-menu" class="w-64 flex-shrink-0 border-r-2 border-custom-primary flex flex-col transition-all duration-300 z-10 overflow-hidden">
    <!-- Logo Header -->
    <div class="flex items-center justify-center shrink-0 mx-1">
        <a href="{{ url('dashboard') }}" class="flex items-center justify-center w-full">
            <img src="{{ asset('imagenes/educacion_menu-nobg.png') }}" class="logo-full object-contain h-28 w-full flex" height="70" alt="Logo">
            <img src="{{ asset('favicon.png') }}" class="logo-collapsed hidden object-contain h-10 w-10 my-3" width="40" height="40" alt="Logo Pequeño">
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-3">
        <div class="space-y-1">
            @foreach($sidebarMenu as $item)
                @continue(!$canView($item))
                @php $active = $isActive($item); @endphp

                @isset($item['items'])
                    {{-- Section with submenu --}}
                    <div @class(['mx-1'])>
                        <div onclick="toggleSubmenu(this)" @class([
                            'cursor-pointer w-full flex items-center justify-between p-2 rounded-lg transition-all has-submenu',
                            'bg-white border-2 border-custom-blue-light text-custom-blue-light' => $active,
                            'text-gray-700 hover:text-custom-blue-light hover:bg-white hover:border-2 hover:border-custom-blue-light' => !$active
                        ])>
                            <div class="flex items-center gap-2 min-w-0">
                                @if(data_get($item,'icon_type') == 'svg')
                                    <img src="{{ $item['icon'] }}" alt="Icono" class="w-7 h-7 flex-shrink-0">
                                @else
                                    <i class="{{ $item['icon'] }} text-xl flex-shrink-0"></i>
                                @endif
                                <span class="font-medium menu-text truncate">{{ $item['label'] }}</span>
                            </div>
                        </div>
                        <ul @class(['submenu pl-8 mt-1 space-y-1', 'hidden' => !$active])>
                            @foreach($item['items'] as $sub)
                                @continue(!$canView($sub))

                                @isset($sub['dynamic'])
                                    @foreach($municipios as $m)
                                        @php $url = $sub['url'].$m->id; @endphp
                                        <li>
                                            <a href="{{ url($url) }}" @class([
                                                'flex items-center gap-2 p-2 rounded-lg text-sm',
                                                'text-custom-blue-light font-bold' => request()->fullUrlIs(url($url)),
                                                'text-custom-blue-light hover:text-custom-blue-light' => !request()->fullUrlIs(url($url))
                                            ])>
                                                <i class="{{ $sub['icon'] }} w-5 text-center flex-shrink-0"></i>
                                                <span class="menu-text truncate">{{ $m->nombre }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    @isset($sub['items'])
                                        @php $subActive = $isActive($sub); @endphp
                                        <li>
                                            <button onclick="toggleSubmenu(this)" class="w-full flex items-center justify-between p-2 rounded-lg text-sm has-submenu">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <i class="{{ $sub['icon'] }} w-5 text-center text-custom-primary flex-shrink-0"></i>
                                                    <div class="text-custom-blue-light menu-text truncate">{{ $sub['label'] }}</div>
                                                </div>
                                            </button>
                                            <ul @class(['submenu pl-4 mt-1 space-y-1', 'hidden' => !$subActive])>
                                                @foreach($sub['items'] as $nested)
                                                    @php $nestedActive = $isActive($nested); @endphp
                                                    <li>
                                                        <a href="{{ url($nested['url']) }}" class="flex items-center gap-2 p-2 rounded-lg text-sm">
                                                            <i class="{{ $nested['icon'] }} w-4 text-center text-custom-primary flex-shrink-0"></i>
                                                            <div class="text-custom-blue-light menu-text truncate">{{ $nested['label'] }}</div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        @php $subActive = $isActive($sub); @endphp
                                        <li>
                                            <a href="{{ url($sub['url']) }}" class="flex items-center gap-2 p-2 rounded-lg text-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-custom-primary flex-shrink-0"></span>
                                                <i class="{{ $sub['icon'] }} text-custom-primary flex-shrink-0"></i>
                                                <span class="text-custom-blue-light font-medium menu-text truncate">{{ $sub['label'] }}</span>
                                            </a>
                                        </li>
                                    @endisset
                                @endisset
                            @endforeach
                        </ul>
                    </div>
                @else
                    {{-- Direct link --}}
                    <div class="mx-1">
                        <a href="{{ url($item['url']) }}" @class([
                            'flex items-center gap-2 p-2 rounded-lg transition-all',
                            'bg-white border-2 border-custom-blue-light text-custom-blue-light font-semibold' => $active,
                            'text-gray-700 hover:text-custom-blue-light hover:bg-white hover:border-2 hover:border-custom-blue-light' => !$active
                        ])>
                            @if(data_get($item,'icon_type') == 'svg')
                                <img src="{{ $item['icon'] }}" alt="Icono" class="w-7 h-7 flex-shrink-0">
                            @else
                                <i class="{{ $item['icon'] }} w-7 h-7 text-center text-lg flex-shrink-0"></i>
                            @endif
                            <div class="menu-text truncate">{{ $item['label'] }}</div>
                        </a>
                    </div>
                @endisset
            @endforeach
        </div>
    </div>

    <!-- Toggle Button -->
    <div class="mt-auto p-2 border-t border-custom-primary hidden lg:block">
        <button id="sidebar-toggle-btn" class="w-full flex items-center justify-center p-2 text-gray-400 hover:text-custom-blue-light transition-colors">
            <i class="bx bx-menu bx-sm"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('layout-menu');
            const backdrop = document.getElementById('content-backdrop');
            const toggleButtons = document.querySelectorAll('.layout-menu-toggle, #sidebar-toggle-btn');

            // LocalStorage key for sidebar state
            const SIDEBAR_STATE_KEY = 'sidebar-collapsed-state';

            // Function to save sidebar state
            function saveSidebarState(isCollapsed) {
                try {
                    localStorage.setItem(SIDEBAR_STATE_KEY, isCollapsed ? 'collapsed' : 'expanded');
                } catch (e) {
                    console.warn('Could not save sidebar state to localStorage:', e);
                }
            }

            // Function to load sidebar state
            function loadSidebarState() {
                try {
                    return localStorage.getItem(SIDEBAR_STATE_KEY) === 'collapsed';
                } catch (e) {
                    console.warn('Could not load sidebar state from localStorage:', e);
                    return false; // Default to expanded
                }
            }

            // Function to expand sidebar
            function expandSidebar(save = true) {
                const logoFull = sidebar.querySelector('.logo-full');
                const logoCollapsed = sidebar.querySelector('.logo-collapsed');
                const menuTexts = sidebar.querySelectorAll('.menu-text');

                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                logoFull?.classList.remove('hidden');
                logoCollapsed?.classList.add('hidden');
                menuTexts.forEach(el => el.classList.remove('hidden'));

                if (save) {
                    saveSidebarState(false);
                }
            }

            // Function to collapse sidebar
            function collapseSidebar(save = true) {
                const logoFull = sidebar.querySelector('.logo-full');
                const logoCollapsed = sidebar.querySelector('.logo-collapsed');
                const menuTexts = sidebar.querySelectorAll('.menu-text');

                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                logoFull?.classList.add('hidden');
                logoCollapsed?.classList.remove('hidden');
                menuTexts.forEach(el => el.classList.add('hidden'));

                // Close all submenus when collapsing
                sidebar.querySelectorAll('.submenu').forEach(el => el.classList.add('hidden'));

                if (save) {
                    saveSidebarState(true);
                }
            }

            // Check if sidebar is collapsed
            function isSidebarCollapsed() {
                return sidebar.classList.contains('w-20');
            }

            // Toggle submenus
            window.toggleSubmenu = function(button) {
                // If sidebar is collapsed and button has submenu, expand sidebar first
                if (window.innerWidth >= 1024 && isSidebarCollapsed() && button.classList.contains('has-submenu')) {
                    expandSidebar();
                    // Wait for transition to complete before opening submenu
                    setTimeout(() => {
                        openSubmenu(button);
                    }, 300);
                    return;
                }

                // Normal submenu toggle
                openSubmenu(button);
            };

            // Function to open/close submenu
            function openSubmenu(button) {
                const submenu = button.nextElementSibling;

                // Close ALL other submenus first
                const allButtons = document.querySelectorAll('[onclick="toggleSubmenu(this)"]');
                allButtons.forEach(otherBtn => {
                    if (otherBtn !== button) {
                        const otherSubmenu = otherBtn.nextElementSibling;
                        if (otherSubmenu && otherSubmenu.classList.contains('submenu')) {
                            otherSubmenu.classList.add('hidden');
                        }
                    }
                });

                if (submenu && submenu.classList.contains('submenu')) {
                    submenu.classList.toggle('hidden');
                }
            }

            // Toggle sidebar
            function toggleSidebar() {
                const isCollapsed = isSidebarCollapsed();

                if (window.innerWidth >= 1024) {
                    // Desktop behavior
                    if (isCollapsed) {
                        expandSidebar();
                    } else {
                        collapseSidebar();
                    }
                } else {
                    // Mobile behavior
                    sidebar.classList.toggle('-translate-x-full');
                    backdrop?.classList.toggle('hidden');
                }
            }

            toggleButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    toggleSidebar();
                });
            });

            // Backdrop click to close on mobile
            if(backdrop) {
                backdrop.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                });
            }

            // Initialize state based on screen size and saved state
            if (window.innerWidth < 1024) {
                // Mobile: always start hidden off-screen
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
            } else {
                // Desktop: load saved state
                const shouldBeCollapsed = loadSidebarState();
                if (shouldBeCollapsed) {
                    collapseSidebar(false); // Don't save again during initialization
                } else {
                    expandSidebar(false); // Don't save again during initialization
                }
            }

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth < 1024) {
                        // Switching to mobile
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('w-20');
                        sidebar.classList.add('w-64');
                    } else {
                        // Switching to desktop - restore saved state
                        sidebar.classList.remove('-translate-x-full');
                        const shouldBeCollapsed = loadSidebarState();
                        if (shouldBeCollapsed) {
                            collapseSidebar(false);
                        } else {
                            expandSidebar(false);
                        }
                    }
                }, 250);
            });
        });
    </script>
</aside>
