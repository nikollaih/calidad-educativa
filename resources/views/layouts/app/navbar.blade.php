<nav class="h-16 bg-custom-blue-dark shadow-sm flex items-center px-4 justify-between z-10" id="layout-navbar">
    <div class="w-full flex items-center justify-between">
        <div id="navbar-item-1" class="flex w-full"></div>

        <div class="flex items-center ml-auto" id="navbar-collapse">
            <div class="flex flex-row items-center ml-auto">
                <li class="relative group">
                    <a class="flex items-center layout-menu-toggle" href="javascript:void(0);" onclick="toggleDropdown(event)">
                        <img src="{{asset('assets/icon/navbar-profile.png')}}" alt="" class="w-11 h-11 rounded-full" />
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                    </a>
                    <ul class="hidden absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50 p-0 m-0 list-none" id="userDropdown">
                        <!-- Perfil de usuario -->
                        <li class="bg-gradient-to-r from-blue-50 to-indigo-50">
                            <a class="block px-2 py-1 hover:bg-white/50 transition-all duration-200" href="{{asset('profile')}}">
                                <div class="flex items-center gap-3">
                                    <div class="relative flex-shrink-0">
                                        @if( session('icono') )
                                            <img src="{{asset('storage/iconos/')}}/{{session('icono')}}" alt="" class="w-12 h-12 rounded-full ring-2 ring-white shadow-md object-cover" />
                                        @else
                                            <img src="{{asset('assets/img/avatars/1.png')}}" alt="" class="w-12 h-12 rounded-full ring-2 ring-white shadow-md object-cover" />
                                        @endif
                                        <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 text-base truncate">
                                            {{ Auth::user() ? Auth::user()->name : 'Sin Perfil' }}
                                        </p>

                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @if (Auth::check() && Auth::user()->roles->isNotEmpty())
                                                @foreach (Auth::user()->roles as $role)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $role->name_translated ?? $role->name }}
                                </span>
                                                @endforeach
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                Sin Rol
                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <!-- Divider -->
                        <li>
                            <div class="border-t border-gray-100"></div>
                        </li>

                        <!-- Cerrar sesión -->
                        <li class="px-2 py-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 rounded-lg text-red-600 hover:bg-red-50 transition-all duration-200 font-medium flex items-center gap-2 group">
                                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>                </li>
            </div>
        </div>

        <div class="hidden">
            <input
                type="text"
                class="w-full border-0 focus:outline-none focus:ring-2 focus:ring-blue-500 px-4 py-2"
                placeholder="Search..."
                aria-label="Search..."
            />
            <i class="bx bx-x text-2xl cursor-pointer"></i>
        </div>
    </div>
</nav>

<script>
    function toggleDropdown(event) {
        event.preventDefault();
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Cerrar dropdown al hacer clic fuera
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const isClickInside = event.target.closest('li.relative.group');

        if (!isClickInside && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
        }
    });
</script>
