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

<aside id="layout-menu" class="w-64 flex-shrink-0 border-r-2 border-custom-primary flex flex-col transition-all duration-300 z-10">
    <!-- Inicio de la imagen cabecera del sidebar -->
    <div class="flex items-center justify-center shrink-0 mx-1">
        <a href="{{ url('dashboard') }}" class="flex items-center justify-center w-full">
            <img src="{{ asset('imagenes/educacion_menu-nobg.png') }}" class="logo-full object-contain h-28 w-full flex" height="70" alt="Logo">
            <img src="{{ asset('favicon.png') }}" class="logo-collapsed hidden object-contain h-10 w-10 my-3" width="40" height="40" alt="Logo Pequeño">
        </a>
    </div>
    <!-- Fin de la imagen cabecera del sidebar -->

    <div class="flex-1 overflow-y-auto py-3">
        <div>
            @foreach($sidebarMenu as $item)
                @continue(!$canView($item))
                @php $active = $isActive($item); @endphp

                @isset($item['items'])
                    {{-- Section with submenu --}}
                    <div @class(['bg-white border-2 border-custom-blue-light mx-1 justify-center rounded-2xl' => $active, 'group justify-center mx-1' => !$active])>
                        <div onclick="toggleSubmenu(this)" @class([' cursor-pointer w-full flex items-center justify-between p-2 rounded-lg', 'text-custom-blue-light border-custom-blue-light' => $active, 'text-gray-700 hover:text-custom-blue-light hover:bg-white hover:border-2 hover:rounded-full hover:border-custom-blue-light  transition-colors' => !$active])>
                            <div class="flex items-center gap-2 mx-2">
                                @if(data_get($item,'icon_type') == 'svg')
                                    <img src="{{ $item['icon'] }}" alt="Icono" width="28">
                                @else
                                    <i class="{{ $item['icon'] }} text-xl"></i>
                                @endif
                                <span class="font-medium ">{{ $item['label'] }}</span>
                            </div>
                        </div>
                        <ul @class(['submenu pl-8 mt-1 space-y-1', 'hidden' => !$active])>
                            @foreach($item['items'] as $sub)
                                @continue(!$canView($sub))

                                @isset($sub['dynamic'])
                                    @foreach($municipios as $m)
                                        @php $url = $sub['url'].$m->id; @endphp
                                        <li>
                                            <a href="{{ url($url) }}" @class(['flex items-center gap-2 p-2 rounded-lg text-sm', 'text-custom-blue-light font-bold' => request()->fullUrlIs(url($url)), 'text-custom-blue-light hover:text-custom-blue-light ' => !request()->fullUrlIs(url($url))])>
                                                <i class="{{ $sub['icon'] }} w-5 text-center"></i>
                                                <span>{{ $m->nombre }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    @isset($sub['items'])
                                        @php $subActive = $isActive($sub); @endphp
                                        <li>
                                            <button onclick="toggleSubmenu(this)" @class(['w-full flex items-center justify-between p-2 rounded-lg text-sm'])>
                                                <div class="flex items-center gap-2">
                                                    <i class="{{ $sub['icon'] }} w-5 text-center text-custom-primary"></i>
                                                    <div class="text-custom-blue-light">{{ $sub['label'] }}</div>
                                                </div>
                                            </button>
                                            <ul @class(['submenu pl-4 mt-1 space-y-1', 'hidden' => !$subActive])>
                                                @foreach($sub['items'] as $nested)
                                                    @php $nestedActive = $isActive($nested); @endphp
                                                    <li>
                                                        <a href="{{ url($nested['url']) }}" @class(['flex items-center gap-2 p-2 rounded-lg text-sm'])>
                                                            <i class="{{ $nested['icon'] }} w-4 text-center text-custom-primary"></i>
                                                            <div class="text-custom-blue-light">{{ $nested['label'] }}</div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        @php $subActive = $isActive($sub); @endphp
                                        <li>
                                            <a href="{{ url($sub['url']) }}" @class(['flex items-center gap-2 p-2 rounded-lg text-sm'])>
                                                <span class="w-1.5 h-1.5 rounded-full bg-custom-primary"></span>
                                                <i class="{{ $sub['icon'] }} text-custom-primary"></i>
                                                <span class="text-custom-blue-light font-medium">{{ $sub['label'] }}</span>
                                            </a>
                                        </li>
                                    @endisset
                                @endisset
                            @endforeach
                        </ul>
                    </div>
                @else
                    {{-- Direct link --}}
                    <div @class([' bg-white border-2 border-custom-blue-light mx-1 justify-center rounded-full' => $active])>
                        <a href="{{ url($item['url']) }}"  @class(['flex items-center gap-2 p-2 rounded-lg mx-2', 'text-custom-blue-light font-semibold' => $active, 'text-gray-700 hover:text-custom-blue-light hover:bg-white hover:border-2 hover:rounded-full hover:border-custom-blue-light  transition-colors' => !$active])>
                            @if(data_get($item,'icon_type') == 'svg')
                                <img src="{{ $item['icon'] }}" alt="Icono" width="28">
                            @else
                                <i class="{{ $item['icon'] }} w-7 h-7 text-center text-lg"></i>
                            @endif
                            <div class="">{{ $item['label'] }}</div>
                        </a>
                    </div>
                @endisset
            @endforeach

            <li class="mt-auto hidden lg:block">
                <button id="sidebar-toggle-btn" class="w-full flex items-start justify-start p-2 text-gray-400 hover:text-custom-blue-light transition-colors">
                    <i class="bx bx-menu bx-sm"></i>
                </button>
            </li>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle submenus
            window.toggleSubmenu = function(button) {
                const submenu = button.nextElementSibling;
                const li = button.parentElement;
                const icon = button.querySelector('.fa-chevron-down');
                const mainIcon = button.querySelector('div i'); // The main icon on the left

                // Close ALL other submenus first
                const allButtons = document.querySelectorAll('button[onclick="toggleSubmenu(this)"]');
                allButtons.forEach(otherBtn => {
                    if (otherBtn !== button) {
                        const otherSubmenu = otherBtn.nextElementSibling;
                        const otherLi = otherBtn.parentElement;
                        const otherIcon = otherBtn.querySelector('.fa-chevron-down');
                        const otherMainIcon = otherBtn.querySelector('div i');

                        if (otherSubmenu && !otherSubmenu.classList.contains('hidden')) {
                            otherSubmenu.classList.add('hidden');
                            if (otherIcon) otherIcon.classList.remove('rotate-180');

                            // Revert styles for other items
                            otherLi.classList.remove('p-2', 'border', 'border-custom-primary', 'rounded-2xl');
                            otherLi.classList.add('group');

                            otherBtn.classList.remove('text-custom-blue-light', 'font-semibold');
                            otherBtn.classList.add('text-gray-700', '', 'transition-colors');

                            if (otherMainIcon) otherMainIcon.classList.remove('text-custom-blue-light');
                        }
                    }
                });

                if (submenu) {
                    submenu.classList.toggle('hidden');
                    if(icon) icon.classList.toggle('rotate-180');

                    // Toggle visual active state on parent li
                    const isExpanded = !submenu.classList.contains('hidden');

                    if (isExpanded) {
                        li.classList.remove('group');
                        li.classList.add('p-2', 'border-2', 'border-custom-blue-light', 'rounded-2xl','bg-white');
                        button.classList.remove('text-custom-blue-light', 'hover:border-custom-blue-light', 'transition-colors','hover:border-2');
                        button.classList.add('text-custom-blue-light', 'font-semibold');

                        if (mainIcon) mainIcon.classList.add('text-custom-blue-light');
                    } else {
                        li.classList.remove('p-2', 'border-2', 'border-custom-blue-light', 'rounded-2xl','bg-white');
                        li.classList.add('group');

                        button.classList.remove('text-custom-blue-light', 'font-semibold','border-2');
                        button.classList.add('text-gray-700', 'hover:border-custom-blue-light', 'transition-colors','hover:border-2');

                        if (mainIcon) mainIcon.classList.remove('text-custom-blue-light');
                    }
                }
            };

            // Toggle sidebar
            const sidebar = document.getElementById('layout-menu');
            const backdrop = document.getElementById('content-backdrop');
            const toggleButtons = document.querySelectorAll('.layout-menu-toggle, #sidebar-toggle-btn');

            function toggleSidebar() {
                const isCollapsed = sidebar.classList.contains('w-20');
                const logoFull = sidebar.querySelector('.logo-full');
                const logoCollapsed = sidebar.querySelector('.logo-collapsed');

                if (window.innerWidth >= 1024) {
                    // Desktop behavior
                    if (isCollapsed) {
                        // Expand
                        sidebar.classList.remove('w-20');
                        sidebar.classList.add('w-64');
                        logoFull.classList.remove('hidden');
                        logoCollapsed.classList.add('hidden');

                        // Show text
                        sidebar.querySelectorAll('.').forEach(el => el.classList.remove('hidden'));
                        sidebar.querySelectorAll('.fa-chevron-down').forEach(el => el.classList.remove('hidden'));
                    } else {
                        // Collapse
                        sidebar.classList.remove('w-64');
                        sidebar.classList.add('w-20');
                        logoFull.classList.add('hidden');
                        logoCollapsed.classList.remove('hidden');

                        // Hide text
                        sidebar.querySelectorAll('.').forEach(el => el.classList.add('hidden'));
                        sidebar.querySelectorAll('.fa-chevron-down').forEach(el => el.classList.add('hidden'));

                        // Close all submenus
                        sidebar.querySelectorAll('.submenu').forEach(el => el.classList.add('hidden'));
                        sidebar.querySelectorAll('.rotate-180').forEach(el => el.classList.remove('rotate-180'));
                    }
                } else {
                    // Mobile behavior
                    sidebar.classList.toggle('-translate-x-full');
                    backdrop.classList.toggle('hidden');
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

            // Initialize state based on screen size
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('w-20'); // Ensure full width style is applied but hidden
                sidebar.classList.add('w-64');
            }
        });
    </script>
</aside>
