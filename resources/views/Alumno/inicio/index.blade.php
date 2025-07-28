<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ¡Bienvenido, {{ Auth::user()->name }}!
        </h2>
    </x-slot>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="relative min-h-screen flex items-center justify-between px-12 py-12 overflow-hidden gap-12">
        <!-- Fondo borroso dinámico -->
        <div 
            id="background"
            class="absolute inset-0 bg-cover bg-center transition-all duration-1000"
            style="filter: blur(5px); z-index: 0; background-image: url('{{ asset('images/imagen1.jpeg') }}');"
        ></div>

        <!-- Capa oscura encima para mejor contraste -->
        <div class="absolute inset-0 bg-black bg-opacity-40 z-10"></div>

        <!-- Contenido encima del fondo -->
        <div class="relative z-20 flex w-full justify-between items-center gap-12">
      <!-- Tarjeta de texto -->
    <div class="w-1/2 p-8 rounded-xl shadow-xl bg-gradient-to-r from-white/90 to-white/70 text-gray-900 text-justify space-y-4">
        
        <p class="text-lg leading-relaxed">
            Este es tu espacio para gestionar tu informe de práctica profesional. 
            Aquí podrás subir tu documento, recibir observaciones de tus docentes y dar seguimiento a cada etapa del proceso de revisión.
        </p>

        <!-- Indicaciones para comenzar -->
        <div class="bg-blue-600 rounded-xl px-6 py-3 inline-block shadow-md">
            <h2 class="text-white font-bold text-lg">Indicaciones para comenzar</h2>
        </div>
        <p class="text-lg leading-relaxed">
            Y el contenido:
        </p>
 
        <!--Lista en el contenido-->
        <ul class="list-disc list-inside text-gray-900">
            <li>Asegúrate de subir tu informe en formato PDF.</li>
            <li>Revisa constantemente la sección de observaciones.</li>
            <li>Corrige y vuelve a enviar si es necesario.</li>
            <li>Una vez aprobado, podrás ver el estado como "Finalizado".</li>
        </ul>

         <!-- Estado del informe -->
        <div class="bg-blue-600 rounded-xl px-6 py-3 inline-block shadow-md">
            <h2 class="text-white font-bold text-lg">Estado del informe</h2>
        </div>
        <p class="text-lg leading-relaxed">
            Indica en qué etapa del proceso se encuentra:
        </p>

        <ul class="space-y-2 text-gray-800">
            <li><span class="text-red-500 font-bold">●</span> Pendiente: El estudiante subió el informe pero el docente aún no lo revisa.</li>
            <li><span class="text-yellow-500 font-bold">●</span> En proceso: El docente ya hizo obervaciones y está esperando correcciones.</li>
            <li><span class="text-green-500 font-bold">●</span> Finalizado: El informe fue corregido y aprobado.</li>
        </ul>



    </div>

            <!-- Carrusel moderno con controles - Flowbite -->
            <div class="w-1/2 relative">
                <div id="default-carousel" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-64 overflow-hidden rounded-lg md:h-96">
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('images/imagen1.jpeg') }}" class="absolute block w-full h-full object-cover" alt="Imagen 1">
                        </div>
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('images/imagen2.jpeg') }}" class="absolute block w-full h-full object-cover" alt="Imagen 2">
                        </div>
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('images/imagen3.jpeg') }}" class="absolute block w-full h-full object-cover" alt="Imagen 3">
                        </div>
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ asset('images/imagen4.jpeg') }}" class="absolute block w-full h-full object-cover" alt="Imagen 4">
                        </div>
                    </div>

                    <!-- Indicadores -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-4 left-1/2 space-x-3">
                        <button type="button" class="w-3 h-3 rounded-full bg-white" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                        <button type="button" class="w-3 h-3 rounded-full bg-white" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                        <button type="button" class="w-3 h-3 rounded-full bg-white" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                        <button type="button" class="w-3 h-3 rounded-full bg-white" aria-label="Slide 4" data-carousel-slide-to="3"></button>
                    </div>

                    <!-- Botones de navegación -->
                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4" data-carousel-prev>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 6 10"><path d="M5 1 1 5l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span class="sr-only">Anterior</span>
                        </span>
                    </button>
                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4" data-carousel-next>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white/50">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 6 10"><path d="m1 9 4-4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span class="sr-only">Siguiente</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
<footer class="relative z-30 bg-[#004CBE] border-t border-slate-700 text-white">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Primera sección: Información del proyecto y Tecnologías -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <!-- Información del proyecto -->
            <div class="text-center lg:text-left">
                <h3 class="text-lg font-bold mb-3 text-white">
                    Sistema de Gestión de Informes
                </h3>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Plataforma desarrollada para la gestión eficiente de informes de práctica profesional,
                    facilitando el proceso de revisión y seguimiento académico.
                </p>
            </div>

            <!-- Información técnica -->
            <div class="text-center lg:text-right">
                <h3 class="text-lg font-bold mb-3 text-white">Tecnologías</h3>
                <div class="flex flex-wrap justify-center lg:justify-end gap-2 mb-4">
                    <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium">Laravel</span>
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-medium">PHP</span>
                    <span class="bg-teal-500 text-white px-3 py-1 rounded-full text-xs font-medium">Tailwind CSS</span>
                    <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-xs font-medium">JavaScript</span>
                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium">MySQL</span>
                </div>
                
                <!-- Versión y fecha -->
                <div class="space-y-1">
                    <p class="text-xs text-gray-400">Versión 1.0.0</p>
                    <p class="text-xs text-gray-400">Desarrollado en <?php echo date('Y'); ?></p>
                </div>
            </div>
        </div>

            <div class="text-center">
                <a
                    href="{{ route('desarrolladores') }}"
                    class="inline-block text-center w-full max-w-md mx-auto bg-slate-700 hover:bg-slate-600 active:bg-slate-800 rounded-xl px-8 py-5 transition duration-300 border border-slate-600 hover:border-slate-500 hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                    <p class="font-semibold text-white text-lg">Ver Equipo de Desarrollo</p>
                    <p class="text-sm text-gray-300 mt-1">Conoce a nuestro equipo</p>
                    </a>
                </div>
            </div>

        <!-- Línea divisoria final -->
        <div class="border-t border-slate-700 pt-4">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0">
                <!-- Copyright -->
                <div class="text-center md:text-left">
                    <p class="text-gray-400 text-xs">
                        © <?php echo date('Y'); ?> Sistema de Gestión de Informes. Todos los derechos reservados.
                    </p>
                </div>

                <!-- Enlaces adicionales -->
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 text-xs">
                        Política de Privacidad
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 text-xs">
                        Términos de Uso
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300 text-xs">
                        Soporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Mensaje de agradecimiento -->
        <div class="text-center mt-4 pt-4 border-t border-slate-700">
            <p class="text-gray-300 italic text-sm">
                "Desarrollado con 💛 para facilitar el proceso académico"
            </p>
        </div>
    </div>
</footer>

    <!-- Script para sincronizar fondo con imagen activa -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const background = document.getElementById('background');

            const images = [
                "{{ asset('images/imagen1.jpeg') }}",
                "{{ asset('images/imagen2.jpeg') }}",
                "{{ asset('images/imagen3.jpeg') }}",
                "{{ asset('images/imagen4.jpeg') }}"
            ];

            let current = 0;

            const updateBackground = (index) => {
                background.style.backgroundImage = `url('${images[index]}')`;
                current = index;
            };

            // Indicadores (puntos)
            document.querySelectorAll('[data-carousel-slide-to]').forEach((button, index) => {
                button.addEventListener('click', () => updateBackground(index));
            });

            // Flechas
            const prev = document.querySelector('[data-carousel-prev]');
            const next = document.querySelector('[data-carousel-next]');

            prev.addEventListener('click', () => {
                current = (current - 1 + images.length) % images.length;
                updateBackground(current);
            });

            next.addEventListener('click', () => {
                current = (current + 1) % images.length;
                updateBackground(current);
            });

            // Cambio automático cada 5 segundos
            setInterval(() => {
                current = (current + 1) % images.length;
                updateBackground(current);
            }, 7000);
        });
    </script>
</x-app-layout>
