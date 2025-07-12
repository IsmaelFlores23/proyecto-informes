<nav x-data="{ open: false }" class="bg-[#004CBE] border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <!-- Centered Navigation Links -->
            <div class="flex items-center justify-center flex-1">
                {{-- Mobile Menu Button --}}
                <div class="hidden space-x-8 sm:flex">
                    {{-- Inicio --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                        {{ __('Inicio') }}
                    </x-nav-link>

                    {{-- Asignar Terna --}}
                    

                    {{-- Dropdown Gestionar Usuarios --}}
                    <div class="relative">
                        <button id="dropdownGestionarUsuariosButton" data-dropdown-toggle="dropdownGestionarUsuarios" class="text-white inline-flex items-center px-3 py-2 hover:bg-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="button">
                            {{ __('Gestionar Usuarios') }}
                            <svg class="ml-2 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="dropdownGestionarUsuarios" class="hidden absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg">
                            <ul class="py-1 text-gray-700" aria-labelledby="dropdownGestionarUsuariosButton">
                                <li>
                                    <a href="{{ route('GestionarAlumnos.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        {{ __('Alumnos') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('GestionarDocentes.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        {{ __('Docentes') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('GestionarAdmins.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        {{ __('Administradores') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Dropdown Administrar --}}
                    <div class="relative">
                        <button id="dropdownAdministrarButton" data-dropdown-toggle="dropdownAdministrar" class="text-white inline-flex items-center px-3 py-2 hover:bg-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="button">
                            {{ __('Administrar') }}
                            <svg class="ml-2 w-4 h-4" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownAdministrar" class="hidden absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg">
                            <ul class="py-1 text-gray-700" aria-labelledby="dropdownAdministrarButton">
                                <li>
                                    <a href="{{ route('Campus.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        {{ __('Campus') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('Facultades.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        {{ __('Facultades') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('AsignarTerna.create') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        {{ __('Ternas') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('GestionarUsuarios.index')" :active="request()->routeIs('GestionarUsuarios.index')">
                {{ __('Gestionar Usuarios') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('AsignarTerna.index')" :active="request()->routeIs('AsignarTerna.index')">
                {{ __('Asignar Terna') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('AdminInformes.index')" :active="request()->routeIs('AdminInformes.index')">
                {{ __('Administrar Informes') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" :active="request()->routeIs('logout')">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
