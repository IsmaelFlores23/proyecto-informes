<x-app-layout>


    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
        <!-- Nombre del estudiante (solo número de cuenta por ahora) -->
        <div class="text-center font-semibold mb-8">
            Informenes de Alumnos  <!-- esto captura los datos del usuario autenticado -->
        </div>

        <!-- Lista de archivos -->
        <div class="flex flex-col space-y-4">

            <a href="{{ route('docente.observacion.create') }}"
                class="flex items-center justify-between border border-gray-300 rounded-lg px-4 py-2 shadow-sm hover:bg-gray-50 transition">
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 2a2 2 0 0 0-2 2v16c0 1.104.896 2 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13zm-1 9v-4h-2v4H8l4 4 4-4h-3z"/>
                    </svg>
                    Informe de Martin Contreras
                    <span class="text-gray-800"></span>
                </div>
            </a>
           
            <p class="text-center text-gray-500">Este alumno no ha subido ningún informe aún.</p>
            
            <a href="{{ route('docente.historial.index') }}">
                <button type="submit" class="px-4 py-2 text-xs text-white bg-yellow-500 rounded hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-300">
                    Ver Historial de Revisiones
                </button>
            </a>
                
            
        </div>
    </div>
</x-app-layout>