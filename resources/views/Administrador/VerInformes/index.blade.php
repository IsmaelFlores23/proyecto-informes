<x-app-layout>
    <!-- Botón Volver -->
    <div class="max-w-2xl mx-auto mt-6 flex justify-center">
        <a href="{{ route('GestionarUsuarios.index') }}"
           class="px-6 py-2 rounded-md font-semibold text-gray-900 shadow-md bg-yellow-400 hover:bg-yellow-500 transition">
            Volver a la gestión de usuarios
        </a>
    </div>

    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
        <!-- Nombre del estudiante (solo número de cuenta por ahora) -->
        <div class="text-center font-semibold mb-8">
            Informes enviados por: {{ $numero_cuenta }}
        </div>

        <!-- Lista de archivos -->
        <div class="flex flex-col space-y-4">
            @forelse ($archivos as $archivo)
                <a href="{{ route('observarInforme.pdf', ['nombreArchivo' => basename($archivo)]) }}"
                   target="_blank"
                   class="flex items-center justify-between border border-gray-300 rounded-lg px-4 py-2 shadow-sm hover:bg-gray-50 transition">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 2a2 2 0 0 0-2 2v16c0 1.104.896 2 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13zm-1 9v-4h-2v4H8l4 4 4-4h-3z"/>
                        </svg>
                        <span class="text-gray-800">{{ basename($archivo) }}</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </a>
            @empty
                <p class="text-center text-gray-500">Este alumno no ha subido ningún informe aún.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
