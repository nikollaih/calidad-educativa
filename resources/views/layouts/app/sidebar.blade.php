@php
    use Illuminate\Support\Str;
    use App\Helpers\SvgHelper;

$sidebarMenu = [
    [
        'icon' => SvgHelper::getCached('assets/icon/location_city.svg'),
        'icon_type' => 'svg_inline',
        'label' => 'Administración',
        'permission' => 'hr-usuario-ver|s-role-ver|s-permission-ver',
        'role' => 'rector',
        'routes' => 'usuarios*|roles*|permissions*',
        'items' => [
            [
                'url' => 'usuarios',
                'icon' => 'fa-solid fa-users',
                'label' => 'Usuarios',
                'permission' =>
                'hr-usuario-ver'
            ],
            [
                'url' => 'usuarios-institucion',
                'icon' => 'fa-solid fa-users',
                'label' => 'Usuarios de institucion',
                'role' =>'rector',
            ],
            [
                'url' => 'roles',
                'icon' => 'fa-solid fa-cogs',
                'label' => 'Roles',
                'permission' => 's-role-ver'
            ],
            [
                'url' => 'permissions',
                'icon' => 'fa-solid fa-check',
                'label' => 'Permisos',
                'permission' => 's-permission-ver'
            ],
        ]
    ],
    [
        'icon' => SvgHelper::getCached('assets/icon/account_balance.svg'),
        'icon_type' => 'svg_inline',
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
        'icon' => SvgHelper::getCached('assets/icon/build.svg'),
        'icon_type' => 'svg_inline',
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
                'permission' => 's-pam-gestionar',
                'items' => [
                    ['url' => 'unidades-meta', 'icon' => 'fas fa-bullseye', 'label' => 'Indicadores'],
                    ['url' => 'componentes', 'icon' => 'fas fa-bullseye', 'label' => 'Componentes'],
                ]
            ],
            [
                'label' => 'PMI',
                'icon' => 'fas fa-shapes',
                'routes' => 'objetivo*|indicadores*',
                'permission' => 's-institucion-editar',
                'items' => [
                    ['url' => 'objetivo-pmi', 'icon' => 'fas fa-bullseye', 'label' => 'Objetivos'],
                    ['url' => 'indicadores-pmi', 'icon' => 'fas fa-ruler-horizontal', 'label' => 'Indicadores'],
                ]
            ],
        ]
    ],
    [
        'url' => 'pams/index',
        'icon' => SvgHelper::getCached('assets/icon/calendar_month.svg'),
        'icon_type' => 'svg_inline',
        'label' => 'PAM',
        'permission' => 's-pam-consultar|s-pam-gestionar'
    ],
    [
        'url' => 'red-actividades',
        'icon' => SvgHelper::getCached('assets/icon/school.svg'),
        'icon_type' => 'svg_inline',
        'label' => 'Redes pedagógicas',
        'permission' => 's-red-actividad-gestionar',
        'role' => 'rector'
    ],
    [
        'url' => 'pmi/validacion',
        'icon' => SvgHelper::getCached('assets/icon/list_alt_check.svg'),
        'icon_type' => 'svg_inline',
        'label' => 'Validación de PMI',
        'permission' => 's-pmi-validar'
    ],
];

$canView = function($item) {
    $hasPermission = isset($item['permission'])
        ? collect(explode('|', $item['permission']))->some(fn($p) => auth()->user()->can($p))
        : null;

    $hasRole = isset($item['role'])
        ? collect(explode('|', $item['role']))->some(fn($r) => auth()->user()->hasRole($r))
        : null;

    // Si ambos están definidos, debe tener al menos uno
    if ($hasPermission !== null && $hasRole !== null) {
        return $hasPermission || $hasRole;
    }

    // Si solo permission está definido
    if ($hasPermission !== null) {
        return $hasPermission;
    }

    // Si solo role está definido
    if ($hasRole !== null) {
        return $hasRole;
    }

    // Si ninguno está definido, es visible por defecto
    return true;
};



$isActive = fn($item) => match(true) {
    isset($item['exact']) => request()->fullUrlIs(url($item['url'])),
    default => collect(explode('|', $item['routes'] ?? $item['url'].'*'))->some(fn($r) => request()->is($r))
};

// Función para verificar si un item tiene sub-items visibles
$hasVisibleSubItems = function($item) use ($canView, &$hasVisibleSubItems) {
    if (!isset($item['items'])) {
        return false;
    }

    foreach ($item['items'] as $sub) {
        if ($canView($sub)) {
            // Si tiene items anidados, verificar recursivamente
            if (isset($sub['items'])) {
                if ($hasVisibleSubItems($sub)) {
                    return true;
                }
            } else {
                return true;
            }
        }
    }

    return false;
};
@endphp

<aside id="layout-menu"
       class="w-64 flex-shrink-0  border-custom-primary flex flex-col transition-all duration-300 z-10 overflow-hidden"
       style="border-right-width: 1px"
>
    <!-- Logo Header -->
    <div class="flex items-center justify-center shrink-0 mx-1">
        <a href="{{ url('dashboard') }}" class="flex items-center justify-center w-full">
            <img src="{{ asset('imagenes/educacion_menu-nobg.png') }}" class="logo-full object-contain h-28 w-full flex" height="70" alt="Logo">
            <img src="{{ asset('favicon.png') }}" class="logo-collapsed hidden object-contain h-10 w-10 my-3" width="40" height="40" alt="Logo Pequeño">
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-3 ">
        <div class="space-y-1">
            @foreach($sidebarMenu as $item)
                @continue(!$canView($item))
                @php $active = $isActive($item); @endphp

                @isset($item['items'])
                    {{-- Skip if no visible sub-items --}}
                    @continue(!$hasVisibleSubItems($item))

                    {{-- Section with submenu --}}
                    <div @class(['mx-1', '!border rounded-2xl border-custom-blue-light bg-white text-custom-blue-light' => $active])>
                        <div onclick="toggleSubmenu(this)" @class([
                            'cursor-pointer w-full flex items-center justify-between p-2 rounded-lg transition-all has-submenu',
                            '' => $active,
                            'text-gray-700 hover:text-custom-blue-light hover:bg-white hover:!border hover:border-custom-blue-light' => !$active
                        ])>
                            <div class="flex items-center gap-2 min-w-0">
                                @if(data_get($item,'icon_type') == 'svg_inline')
                                    {!! $item['icon'] !!}
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
                                        {{-- Skip nested menu if no visible items --}}
                                        @continue(!$hasVisibleSubItems($sub))

                                        {{-- FIX: subActive es true si la ruta actual coincide con el sub o con alguno de sus nested items --}}
                                        @php
                                            $subActive = $isActive($sub) || collect($sub['items'])->some(fn($n) => $isActive($n));
                                        @endphp
                                        <li>
                                            <button onclick="toggleSubmenu(this)" @class([
                                                'w-full flex items-center justify-between p-2 rounded-lg text-sm has-submenu',
                                                'text-custom-blue-light font-semibold' => $subActive,
                                                'text-custom-blue-light hover:font-semibold' => !$subActive,
                                            ])>
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <i class="{{ $sub['icon'] }} w-5 text-center text-custom-primary flex-shrink-0"></i>
                                                    <div class="menu-text truncate">{{ $sub['label'] }}</div>
                                                </div>
                                                <i @class([
                                                    'fas fa-chevron-down text-xs transition-transform duration-200 flex-shrink-0 mr-1',
                                                    'rotate-180' => $subActive,
                                                ])></i>
                                            </button>
                                            <ul @class(['submenu pl-4 mt-1 space-y-1', 'hidden' => !$subActive])>
                                                @foreach($sub['items'] as $nested)
                                                    @continue(!$canView($nested))
                                                    @php $nestedActive = $isActive($nested); @endphp
                                                    <li>
                                                        <a href="{{ url($nested['url']) }}" @class([
                                                            'flex items-center gap-2 p-2 rounded-lg text-sm',
                                                            'text-custom-blue-light font-bold' => $nestedActive,
                                                            'text-custom-blue-light hover:font-semibold' => !$nestedActive,
                                                        ])>
                                                            <i class="{{ $nested['icon'] }} w-4 text-center text-custom-primary flex-shrink-0"></i>
                                                            <div class="menu-text truncate">{{ $nested['label'] }}</div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        @php $subActive = $isActive($sub); @endphp
                                        <li>
                                            <a href="{{ url($sub['url']) }}" @class([
                                                'flex items-center gap-2 p-2 rounded-lg text-sm',
                                                'text-custom-blue-light font-bold' => $subActive,
                                                'text-custom-blue-light hover:font-semibold' => !$subActive,
                                            ])>
                                                <span class="w-1.5 h-1.5 rounded-full bg-custom-primary flex-shrink-0"></span>
                                                <i class="{{ $sub['icon'] }} text-custom-primary flex-shrink-0"></i>
                                                <span class="font-medium menu-text truncate">{{ $sub['label'] }}</span>
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
                            'bg-white !border border-custom-blue-light text-custom-blue-light font-semibold' => $active,
                            'text-gray-700 hover:text-custom-blue-light hover:bg-white hover:!border hover:border-custom-blue-light' => !$active
                        ])>
                            @if(data_get($item,'icon_type') == 'svg_inline')
                                {!! $item['icon'] !!}
                            @else
                                <i class="{{ $item['icon'] }} w-7 h-7 text-center text-lg flex-shrink-0"></i>
                            @endif
                            <div class="menu-text truncate font-medium">{{ $item['label'] }}</div>
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
            const toggleButtons = document.querySelectorAll('#sidebar-toggle-btn');

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
                const parentDiv = button.parentElement;

                // Detectar si es un botón de segundo nivel (dentro de un submenu ya existente)
                const isNestedButton = button.closest('.submenu') !== null;

                if (!isNestedButton) {
                    // Solo cerrar otros submenus de primer nivel si NO es un botón anidado
                    const allTopLevelButtons = document.querySelectorAll('#layout-menu > div.flex-1 > div > div > [onclick="toggleSubmenu(this)"]');
                    allTopLevelButtons.forEach(otherBtn => {
                        if (otherBtn !== button) {
                            const otherBtnParent = otherBtn.parentElement;
                            otherBtnParent.classList.remove('bg-white', '!border', 'border-custom-blue-light', 'font-semibold','text-custom-blue-light');
                            otherBtnParent.classList.add('text-gray-700','hover:!border','hover:bg-white');
                            otherBtn.classList.remove('text-custom-blue-light','border-custom-blue-light');
                            const otherSubmenu = otherBtn.nextElementSibling;
                            if (otherSubmenu && otherSubmenu.classList.contains('submenu')) {
                                otherSubmenu.classList.add('hidden');
                            }
                        }
                    });

                    // Deselect all direct links principales
                    const allDirectLinks = sidebar.querySelectorAll('a[class*="flex items-center gap-2 p-2 rounded-lg"]');
                    allDirectLinks.forEach(link => {
                        if (!link.closest('.submenu')) {
                            link.classList.remove('bg-white', '!border', 'border-custom-blue-light', 'text-custom-blue-light', 'font-semibold');
                            link.classList.add('text-gray-700', 'hover:text-custom-blue-light', 'hover:bg-white', 'hover:!border', 'hover:border-custom-blue-light');
                        }
                    });
                }

                if (submenu && submenu.classList.contains('submenu')) {
                    submenu.classList.toggle('hidden');
                    const isVisible = !submenu.classList.contains('hidden');

                    // Rotar el chevron si existe
                    const chevron = button.querySelector('.fa-chevron-down');
                    if (chevron) {
                        chevron.classList.toggle('rotate-180', isVisible);
                    }

                    if (!isNestedButton) {
                        if (isVisible) {
                            parentDiv.classList.add('bg-white', '!border', 'border-custom-blue-light', 'text-custom-blue-light', 'font-semibold', 'rounded-2xl');
                            parentDiv.classList.remove('text-gray-700');
                            button.classList.remove('hover:!border','hover:bg-white','text-gray-700');
                            button.classList.add('text-custom-blue-light');
                        } else {
                            parentDiv.classList.remove('bg-white', '!border', 'border-custom-blue-light', 'font-semibold','text-custom-blue-light');
                            parentDiv.classList.add('text-gray-700','hover:!border','hover:bg-white', 'hover:border-custom-blue-light','hover:text-custom-blue-light');
                            button.classList.remove('text-custom-blue-light','!border','bg-white');
                        }
                    }
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
