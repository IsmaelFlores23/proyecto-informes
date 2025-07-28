<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Equipo de Desarrollo
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50">
        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-6 py-12">
            <!-- Introduction -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">
                    Conoce a Nuestro Equipo
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Un grupo talentoso de profesionales dedicados a crear soluciones innovadoras 
                    para la gestión académica. Cada miembro aporta su experiencia única para 
                    hacer posible este sistema.
                </p>
            </div>

            <!-- Developers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($developers as $developer)
                <div class="bg-white rounded-2x1 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border border-gray-100 overflow-hidden">
                    <!--Imagen -->
                    <div class="relative h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <img
                            src="{{ $developer['avatar'] }}"
                            alt="{{ $developer['name'] }}"
                            class="w-28 h-28 rounded-full border-4 border-white shadow-lg object-cover"
                        />
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">
                            {{ $developer['name'] }}
                        </h3>
                        <p class="text-blue-600 font-medium mb-3">
                            {{ $developer['role'] }}
                        </p>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                            {{ $developer['description'] }}
                        </p>

                        <!-- Skills -->
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach($developer['skills'] as $skill)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-medium">
                                    {{ $skill }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Team Stats -->
            <div class="mt-16 bg-white rounded-2xl shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">
                    Estadísticas del Equipo
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ count($developers) }}</div>
                        <div class="text-gray-600">Desarrolladores</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">5+</div>
                        <div class="text-gray-600">Tecnologías</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">1</div>
                        <div class="text-gray-600">Proyecto Exitoso</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-orange-600 mb-2">100%</div>
                        <div class="text-gray-600">Dedicación</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>